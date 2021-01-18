<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupRequest;
use App\Models\Direction;
use App\Models\Group;
use App\Models\LevelEducation;
use App\Models\StudyYear;
use App\Providers\StudentGroupService;
use http\Env\Response;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function createGroup(GroupRequest $request){
        $this->service = new StudentGroupService();

        $group = new Group();
        $group->name = $request["name"];
        $group->lvl_education_id = $request["lvl_education_id"];
        $group->study_year_id = $request["study_year_id"];
        $group->course = $request["course"];
        $group->direction_id = $request["direction_id"];


        if($this->service->getGroupByNameYearCourse($group->name, $group->study_year_id, $group->course) != null){
            return response()->json(['Group already exists'], 400);
        }
        $group->save();
        return response()->json($group);
    }

    public function getGroup(int $id){
        if($id != null)
            return response()->json(Group::find($id));
    }

    public function getGroupByNameYear(string $name, int $study_year_id){
        $group = Group::whereName($name)->where('study_year_id', '=', $study_year_id)->first();
        if( $group == null ){
            return response()->json(['Group Not Found']);
        }
        return response()->json($group);
    }

    public function getDirectionByName(string $name){
        return response()->json(Direction::whereName($name)->first());
    }

    public function getStudyYearByYear(int $year){
        return response()->json(StudyYear::whereStartYear($year)->first());
    }

    public function getLevelEducation(string $name){
        return response()->json(LevelEducation::whereName($name)->first());
    }

    public function changeGroupName(int $group_id, string $name){
        $group = Group::find($group_id);

        if($group == null)
            return response(["Group not found"], 404);

        if(Group::whereName($name)->first() != null)
            return response(["Group with this name is already exists"], 400);

        $group->name = $name;
        $group->update();
        return response()->json($group);
    }
}
