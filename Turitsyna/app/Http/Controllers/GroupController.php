<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGroupRequest;
use App\Models\Direction;
use App\Models\Group;
use App\Providers\StudentGroupService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    private StudentGroupService $service;

    //Дописать метод получения списка групп с фильтрацией
    //список курсов, учебный год
    public function createGroup(CreateGroupRequest $request){
        $group = new Group();
        $group->name = $request->name;
        $group->lvl_education_id = $request->lvl_education_id;
        $group->study_year_id = $request->study_year_id;
        $group->course = $request->course;
        $group->direction_id = $request->directioin_id;

        if($this->service->getGroupByNameYearCourse($group->name, $group->study_year_id, $group->course) != null){
            return response()->json(['Group already exists'], 400);
        }
        $group->save();
        return response()->json($group, 200);
    }

    public function getGroup(int $id){
        if($id != null)
        return Group::find($id);
    }

    /*
     * Изменяет название группы
     * request - id(group), name
     */
    public function changeGroupName(Request $request){
        $group = Group::find($request->id);

        if($group == null)
            return response(["Group not found"], 404);

        if(Group::whereName($request->name)->first() != null)
            return response(["Group with this name is already exists"], 400);

        $group->name = $request->name;
        $group->update();
        return response()->json($group, 200);
    }
}
