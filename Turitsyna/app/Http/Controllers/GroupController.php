<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGroupRequest;
use App\Models\Direction;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{

    //Дописать метод получения списка групп с фильтрацией
    //список курсов, учебный год
    public function createGroup(CreateGroupRequest $request){
        $group = new Group();
        $group->name = $request->name;
        $group->lvl_education_id = $request->lvl_education_id;
        $group->study_year_id = $request->study_year_id;
        $group->course = $request->course;
        $group->direction_id = $request->directioin_id;
        $group->save();
    }

    public function getGroup(int $id){
        if($id != null)
        return Group::find($id);
    }



    // Вернуть все группы по направлениям
    // map: direction : array<groups>
    public function getAllGroups(){
        $directions = Direction::all();
        $groups = array();
        foreach ($directions as $direction){
            $groups[$direction->name] = Group::all()->where("direction_id", '=', $direction->id);
        }
        return $groups;
    }


    /*
     * Изменяет название группы
     * request - id(group), name
     */
    public function changeGroupName(Request $request){
        $group = Group::find($request->id);
        if($group == null)
            return response(["Group not found"], 404);
        if(Group::all()->where("name", '=', $request->name)
                       ->first() != null)
            return response(["Group with this name is already exists"], 400);
        $group->name = $request->name;
        $group->save();
    }

    /*
     * Получить список студентов конкретной группы
     */
    public function getListOfStudents($group_id){
        if( Group::find($group_id) == null){
            return response(["Group not found"], 404);
        }
        $student_list = DB::table('group')
            ->join('student_group', 'group.id', '=', 'student_group.group_id')
            ->join('student', 'student.id', '=', 'student_group.student_id')
            ->select('students.*')
            ->where('group.id', '=', $group_id)
            ->get();

        return response($student_list, 200);
    }
}
