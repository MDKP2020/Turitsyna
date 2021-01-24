<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Status;
use App\Models\StudentGroup;
use App\Models\StudentList;
use App\Models\StudyYear;
use App\Providers\StudentGroupService;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    public function createTransferList(){
        $this->service = new StudentGroupService();
        $graduate_groups = $this->service->getStudentsAndGroups(
                        Group::all()->where('course','=',4)
                        ->where('study_year_id','=', $this->service->currentYear()->id));

        foreach ($graduate_groups as $graduate_group){

            if($graduate_group != null && empty($graduate_group->students)){

                return response()->json(['Cant transfer students'], 400);
            }
        }

        // Выбирем группы 4-го курса
        // Магистратура и специалитет не поддерживаются
        $groups = Group::all()->where('course','<',4)
            ->where('study_year_id','=', $this->service->currentYear()->id);

        if($groups == null){
            return response()->json(['Not found 1-3 course groups'],404);
        }

        return response()->json($this->service->getStudentsAndGroupsNextCourse($groups));
    }
    /*[
     * key - str
     * item - Class { name : string; students : array<Students> }
     *]
     * ["PRIN":{"PRIN-166"; [VASYA, GRISHA]}, {"PRIN-167"; [DANYA, MASHA]};
     *  "IVT" :{"IVT-262"; [PASHA, VITYA]}]
     */
    public function transferStudents(){
        $this->service = new StudentGroupService();

        // Получить группы до 4-го курса
        $old_groups = Group::all()->where('course','<',4)
            ->where('study_year_id','=', $this->service->currentYear()->id);
        if($old_groups == null){
            return response()->json(['Not found 1-3 course groups'],404);
        }
        $study_year = new StudyYear();
        $study_year->start_year = $this->service->currentYear()->start_year + 1;
        $study_year->save();

        //  Создать список групп на курс старше
        $new_groups = array(new Group());
        foreach($old_groups as $old_group){
            $new_group = new Group();

            // Создаем новую группу на основе старой
            $pos = strpos($old_group->name, '-');
            $new_group->name = substr_replace($old_group->name, strval($old_group->course + 1),  $pos+1, 1);
            $new_group->course = $old_group->course + 1;
            $new_group->direction_id = $old_group->direction_id;
            $new_group->lvl_education_id = $old_group->lvl_education_id;
            $new_group->study_year_id = $study_year->id;
            $new_group->save();
            $new_groups[]=$new_group;

            $old_group_studList = StudentList::createStudList($old_group);
            if($old_group_studList == null) continue;

            foreach ($old_group_studList->getStudents() as $student) {
                // Сделать привязку зачисления к новой группе
                $new_student_group = new StudentGroup();
                $new_student_group->group_id = $new_group->id;
                $new_student_group->status_id = Status::whereName('Enrolled')->first()->id;
                $new_student_group->date = Carbon::now()->format('d-m-Y');
                $new_student_group->student_id = $student->id;
                $new_student_group->save();

                // Сделать привязки отчисления к старой группе
                $old_student_group = new StudentGroup();
                $old_student_group->group_id = $old_group->id;
                $old_student_group->status_id = Status::whereName('Expelled')->first()->id;
                $old_student_group->date = Carbon::now()->format('d-m-Y');
                $old_student_group->student_id = $student->id;
                $old_student_group->save();
            }
        }
        return response()->json([], 201);
    }
}
