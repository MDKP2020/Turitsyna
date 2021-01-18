<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\StudyYear;
use App\Providers\StudentGroupService;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    public function createTransferList(){
        $this->service = new StudentGroupService();
        //TODO сделать проверку на наличие групп 4-го курса

        // Выбирем группы 4-го курса
        // Магистратура и специалитет не поддерживаются
        $groups = Group::all()->where('course','<',4)
            ->where('study_year_id','=', $this->service->currentYear()->id);

        if($groups == null){
            return response()->json(['Not found 1-3 course groups'],404);
        }

        return response()->json($this->service->getStudentsAndGroupsNextCourse($groups));
    }
    /*[
     * key - str
     * item - Class { name : string; students : array<Students> }
     *]
     * ["PRIN":{"PRIN-166"; [VASYA, GRISHA]}, {"PRIN-167"; [DANYA, MASHA]};
     *  "IVT" :{"IVT-262"; [PASHA, VITYA]}]
     */
    public function transferStudents(Request $request){
        $this->service = new StudentGroupService();

        $study_year = new StudyYear();
        $study_year->start_year = $this->service->currentYear()->start_year + 1;
        $study_year->save();
    }
}
