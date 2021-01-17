<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Period;
use App\Models\Status;
use App\Models\Student;
use App\Models\Student_group;
use App\Models\StudyYear;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    // Контроллер для методов зачисления

    //Проверяет какой сейчас период
    protected static function isEnrolmentPeriod() : bool{
        return self::currentPeriod()->name == 'Enrollment';
    }

    /*
     * Добавляет студента в бд и зачисляет его в группу
     *
     * request - name, surname, patronomyc, group_id
     */
    public function addStudentToGroup(Request $request){
        if(!self::isEnrolmentPeriod()){
            return response(["Not enrollment period"], 400);
        }

        $student = new Student();
        $student->name = $request->name;
        $student->surname = $request->surname;
        $student->patronomyc = $request->patronomyc;
        $student->save();

        $student_group = new Student_group();
        $student_group->date = Carbon::now()->format('d-m-Y');
        $student_group->student_id = $student->id;
        $student_group->group_id = $request->group_id;
        $student_group->status_id = $request->Status::find('Enrolled')->id;
        $student_group->save();

        return response()->json($student_group, 201);
    }

    /*
     * Удаляет студента из группы
     *
     * request - name, surname, patronomyc, group_id
     */
    public function deleteStudentFromGroup(int $student_id,int $group_id){
        /*if($this->currentPeriod()->name != 'Enrollment'){
            return response(["Not enrollment period"], 400);
        }*/

        Student_group::all()
                ->where("student_id", '=', $student_id )
                ->where("group_id", '=', $group_id )
                ->first()
                ->delete();
    }

    //
    public function changeStudentsGroup($student_id, $old_group_id, $new_group_id )
    {
        if ($this->currentPeriod()->name != 'Enrollment') {
            return response(["Not enrollment period"], 400);
        }

        $student = Student::find($student_id);

        $this->deleteStudentFromGroup($student_id, $old_group_id);

        $this->addStudentToGroup(Request::create(null, null, array(
            "name"     => $student->name,
            "surname"     => $student->surname,
            "patronomyc"     => $student->patronomyc,
            "group_id"    => $new_group_id,
        )));
        return response()->json(null,200);
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
            return response(null, 200);
        } else {
            return response()->json($emptyGroups, 200);
        }
    }







}
