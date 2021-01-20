<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\StudentList;
use App\Providers\StudentGroupService;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // request - name, surname, patronomyc
    public function getStudentByFIO(Request $request){
        $this->service = new StudentGroupService();

        if($request['name'] == null || $request['surname'] == null || $request['patronomyc'] == null){
            return response()->json(['Not enough information'], 400);
        }
        return response()->json($this->service->getStudentByFIO($request['name'], $request['surname'], $request['patronomyc']));
    }

    //
    public function getStudentsFromGroup(int $group_id){
        $group = Group::find($group_id);

        if ($group == null) {
            return response()->json(['There is no group with such id'], 400);
        }

        $student_list = StudentList::createStudList($group);

        if($student_list == null) return response()->json([
            'name' => $group->name,
            'students' => []
        ]);

        return response()->json([
            'name' => $student_list->getGroup(),
            'students' => $student_list->getStudents()
        ]);
    }

    //
    public function getStudentsAndGroups(Request $request){
        $this->service = new StudentGroupService();

        // Если год не указан, то ставим текущий
        if($request['study_year_id'] == null){
            $request['study_year_id'] = $this->service->currentYear()->id;
        }

        // Фильтруем записи по указанным фильтрам
        $groups = Group::filter($request->all())->get();

        $list = $this->service->getStudentsAndGroups($groups);

        $direction_id = $request["direction_id"] != null ? $request["direction_id"] : array();


        return response()->json([
            "PRIN" => [
                'name' => in_array( 1, $direction_id) ? array_values(array_values($list)[0])[0]->group : null,
                'students' => in_array( 1, $direction_id) ? array_values(array_values($list)[0])[0]->students : null],
            "IVT" => [
                'name' => in_array( 2, $direction_id) ? array_values(array_values($list)[1])[0]->group: null,
                'students' => in_array( 2, $direction_id) ? array_values(array_values($list)[1])[0]->students : null],
            "IIT" => [
                'name' => in_array( 3, $direction_id) ? array_values(array_values($list)[2])[0]->group: null,
                'students' => in_array( 4, $direction_id) ? array_values(array_values($list)[2])[0]->students: null],
            "FIZ" => [
                'name' => in_array( 4, $direction_id) ? array_values(array_values($list)[3])[0]->group : null,
                'students' => in_array( 4, $direction_id) ? array_values(array_values($list)[3])[0]->students : null]
        ]);
    }
}
