<?php

namespace App\Http\Controllers;

use App\Models\Direction;
use App\Models\Group;
use App\Models\StudentList;
use App\Providers\StudentGroupService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Environment\Console;

class ExpulsionController extends Controller
{
    private StudentGroupService $service;
    //
    public function createExpulsionList(){
        //Выбирем группы 4-го курса
        $groups = Group::all()->where('course','=',4)
                              ->where('study_year_id','=', Controller::currentYear()->id);

        return response()->json($this->service->getStudentsAndGroups($groups), 200);
    }

    // request - Student
    public function expulsionStudent(Request $request){
        // Сначала удалить привязку, Проверить единственный ли в группе и удалить группу, потом студента

    }

    public function expulsionGroup(Request $request){

    }

    public function expulsionAll(Request $request){

    }
}
