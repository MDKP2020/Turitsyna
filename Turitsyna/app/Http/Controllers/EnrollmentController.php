<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Status;
use App\Models\Student;
use App\Models\StudentGroup;
use App\Providers\StudentGroupService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    private StudentGroupService $service;

    /*
     * Добавляет студента в бд и зачисляет его в группу
     *
     * request - name, surname, patronomyc, group_name
     */
    public function addStudentToGroup(Request $request){

        if($request->name == null || $request->surname == null || $request->patronomyc == null || $request->group_name == null){
            return response()->json(['Not enough information'], 400);
        }

        //Создаем студента
        $student = new Student();
        $student->name = $request->name;
        $student->surname = $request->surname;
        $student->patronomyc = $request->patronomyc;

        //Проверяем наличие студента в базе
        $tmp_student = $this->service->getStudentByFIO($request->name, $request->surname, $request->patronomyc);
        if( $tmp_student != null) {
            //Проверяем обучается ли студент на данный момент
            $enrolled_cnt = $tmp_student->student_group()->where('status_id','=', Status::whereName('Enrolled')->id)->count();
            $expelled_cnt = $tmp_student->student_group()->where('status_id','=', Status::whereName('Expelled')->id)->count();
            if($enrolled_cnt > $expelled_cnt){
                return response()->json(['Student is studying'], 400);
            }
        }
        //Сохраняем студента в бд
        $student->save();

        //Создаем  привязку к группе
        $student_group = new StudentGroup();
        $student_group->date = Carbon::now()->format('d-m-Y');
        $student_group->student_id = $student->id;
        $student_group->group_id = $request->group_id;
        $student_group->status_id = Status::whereName('Enrolled')->id;
        $student_group->save();

        return response()->json([$student, $student_group], 201);
    }

    // request - name, surname, patronomyc, group_id
    // Для ошибочно занесенных
    public function deleteStudentFromGroup(int $student_id,int $group_id){
        if($student_id == null || $group_id == null){
            return response()->json(['Not enough information'], 400);
        }
        StudentGroup::all()
                ->where("student_id", '=', $student_id )
                ->where("group_id", '=', $group_id )
                ->first()
                ->delete();
    }

    //
    public function changeStudentsGroup($student_id, $old_group_id, $new_group_id )
    {
        $student = Student::find($student_id);

        $this->deleteStudentFromGroup($student_id, $old_group_id);

        $this->addStudentToGroup(Request::create(null, null, array(
            "name"     => $student->name,
            "surname"     => $student->surname,
            "patronomyc"     => $student->patronomyc,
            "group_id"    => $new_group_id,
        )));
        return response()->json(['']);
    }

    //NOT NEEDED
    public function checkEmptyGroups(){
        //запрос на пустые группы в текущем году
        $groups = Group::all()->where('study_year_id', '=', $this->currentYear()->id);
        $emptyGroups = array();

        foreach ($groups as $group){
            if($group->student_group()->count() == 0){
                $emptyGroups[] = $group;
            }
        }
        if(count($emptyGroups) == 0 ){
            return response([]);
        } else {
            return response()->json($emptyGroups);
        }
    }







}
