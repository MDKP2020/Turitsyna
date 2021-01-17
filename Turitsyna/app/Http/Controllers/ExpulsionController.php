<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpulsionController extends Controller
{
    public function createExpulsionList(){
        //return DB::statement('select * from student inner join student_group on student.id = student_group.student_id inner join `group` on `group`.id = student_group.proup_id inner join level_education on level_education.id = `group`.lvl_education_id where `group`.course = level_education.period_of_study  and student_group.status_id = 2');

    }

    // request -
    public function expulsion(Request $request){

    }
}
