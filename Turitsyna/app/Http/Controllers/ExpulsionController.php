<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Status;
use App\Models\Student;
use App\Models\StudentGroup;
use App\Models\StudentList;
use App\Providers\StudentGroupService;
use Carbon\Carbon;

class ExpulsionController extends Controller
{
    //kinda useless
    public function createExpulsionList(){
        $this->service = new StudentGroupService();
        //Выбирем группы 4-го курса
        $groups = Group::all()->where('course','=',4)
                              ->where('study_year_id','=', $this->service->currentYear()->id);

        return response()->json($this->service->getStudentsAndGroups($groups));
    }

    //
    public function expulsionStudent(int $student_id){
        $this->service = new StudentGroupService();
        $student = Student::find($student_id);

        //Проверяем на наличие студента
        if($student == null){
            return response()->json(['Student not found'], 404);
        }

        // Создаем запись о том, что студент был отчислен
        $student_group = new StudentGroup();
        $student_group->id = StudentGroup::max('id')+1;
        $student_group->date = Carbon::now();
        $student_group->student_id = $student->id;
        $student_group->group_id = $this->service->lastStudentGroup($student)->group->id;
        $student_group->status_id = Status::whereName('Expelled')->first()->id;
        $student_group->save();

        return response()->json([]);
    }

    //
    public function expulsionGroup(int $group_id){
        $group = Group::find($group_id);
        if($group == null){
            return response()->json(['Group not found'], 404);
        }

        //Получаем список студентов для группы
        $st_list = StudentList::createStudList($group);
        if($st_list == null) return response()->json([], 404);
        $students = $st_list->getStudents();

        //Для каждого студента, который не отчислился, создаем запись об отчислении
        foreach ($students as $student){
            if($student->student_group()->count() % 2 == 1){
                $student_group = new StudentGroup();
                $student_group->id = StudentGroup::max('id')+1;
                $student_group->date = Carbon::now();
                $student_group->student_id = $student->id;
                $student_group->group_id = $group_id;
                $student_group->status_id = Status::whereName('Expelled')->first()->id;
                $student_group->save();
            }
        }
        return response()->json([]);
    }


    public function expulsionGraduates(){
        $this->service = new StudentGroupService();
        //Выбирем группы 4-го курса.
        //Магистратура и специалитет не поддерживаются
        $groups = Group::all()->where('course','=',4)
            ->where('study_year_id','=', $this->service->currentYear()->id);

        if($groups == null){
            return response()->json(['Not found 4-th course groups'],404);
        }

        foreach ($groups as $group){
            //Получаем список студентов
            $st_list = StudentList::createStudList($group);
            if($st_list == null) continue;
            $students = $st_list->getStudents();

            //Для каждого студента, который не отчислился, создаем запись об отчислении
            foreach ($students as $student){
                if($student->student_group()->count() % 2 == 1){
                    $student_group = new StudentGroup();
                    $student_group->id = StudentGroup::max('id')+1;
                    $student_group->date = Carbon::now();
                    $student_group->student_id = $student->id;
                    $student_group->group_id = $group->id;
                    $student_group->status_id = Status::whereName('Expelled')->first()->id;
                    $student_group->save();
                }
            }

        }
        return response()->json([]);
    }
}
