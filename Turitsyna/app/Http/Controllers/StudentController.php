<?php

namespace App\Http\Controllers;

use App\Models\Direction;
use App\Models\Group;
use App\Models\StudentList;
use Illuminate\Http\Request;

class StudentController extends Controller
{
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

        //Итоговый массив
        $result_list = array();
        $directions = Direction::all();

        //По всем направлениям обучения
        foreach ($directions as $direction){
            $tmp_arr = array();
            //По всем группам по этому направлению формируем список студентов {name: "IVT-260"; students: [..]}
            foreach($groups->where('direction_id', '=', $direction->id) as $group){
                $tmp_arr[] = StudentList::createStudList($group);
            }
            //Добавляем список групп и студентов в данном направлении в итоговый массив
            $result_list[$direction->name] = $tmp_arr;
        }
        return response()->json($result_list, 200);
    }
}
