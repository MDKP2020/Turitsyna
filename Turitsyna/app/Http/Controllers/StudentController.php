<?php

namespace App\Http\Controllers;

use App\Models\Direction;
use App\Models\Group;
use App\Models\Student;
use App\Models\StudentList;
use App\Providers\StudentGroupService;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    private StudentGroupService $service;

    // request - name, surname, patronomyc
    public function getStudentByFIO(Request $request){
        if($request->name == null || $request->surname == null || $request->patronomyc == null){
            return response()->json(['Not enough information'], 400);
        }
        return response()->json($this->service->getStudentByFIO($request->name, $request->surname, $request->patronomyc), 200);
    }

    //
    public function getStudentsFromGroup(int $group_id){
        $group = Group::find($group_id);
        $student_list = StudentList::createStudList($group);

        return response()->json($student_list, 200);
    }

    //
    public function getStudentsAndGroups(Request $request){
        // Если год не указан, то ставим текущий
        if($request->study_year_id == null){
            $request->study_year_id = Controller::currentYear()->id;
        }

        // Фильтруем записи по указанным фильтрам
        $groups = Group::filter($request->all())->get();

        return response()->json($this->service->getStudentsAndGroups($groups), 200);
    }
}
