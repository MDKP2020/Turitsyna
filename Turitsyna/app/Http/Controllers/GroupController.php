<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    //
    public function getGroup(int $id){
        return Group::find($id);
    }

    public function getAllGroups(){
        return Group::all();
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
