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

        if($request->name == null || $request->surname == null || $request->patronomyc == null){
            return response()->json(['Not enough information'], 400);
        }
        return response()->json($this->service->getStudentByFIO($request->name, $request->surname, $request->patronomyc), 200);
    }

    //
    public function getStudentsFromGroup(int $group_id){
        $group = Group::find($group_id);

        $student_list = StudentList::createStudList($group);
        //ddd($student_list);
        return response()->json([
            'name' => $student_list->getGroup(),
            'students' => $student_list->getStudents(),
        ]);
        //return response(json_encode(($student_list)));
    }

    //
    public function getStudentsAndGroups(Request $request){
        $this->service = new StudentGroupService();

        // Если год не указан, то ставим текущий
        if($request->study_year_id == null){
            $request->study_year_id = $this->service->currentYear()->id;
        }

        // Фильтруем записи по указанным фильтрам
        $groups = Group::filter($request->all())->get();
        $list = $this->service->getStudentsAndGroups($groups);

        return response()->json([
            "PRIN" => [
                       'name' => array_values(array_values($list)[0])[0]->group,
                       'students' => array_values(array_values($list)[0])[0]->students],
            "IVT" => [
                'name' => array_values(array_values($list)[1])[0]->group,
                'students' => array_values(array_values($list)[1])[0]->students],
            "IIT" => [
                'name' => array_values(array_values($list)[2])[0]->group,
                'students' => array_values(array_values($list)[2])[0]->students],
            "FIZ" => [
                'name' => array_values(array_values($list)[3])[0]->group,
                'students' => array_values(array_values($list)[3])[0]->students]
        ]);
        //return response()->json($this->service->getStudentsAndGroups($groups));
    }
}
