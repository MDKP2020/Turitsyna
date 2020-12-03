<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\StudyYear;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $current_year;

    protected static function currentPeriod(){
        $current_year = StudyYear::max('start_year');
        return Period::find($current_year->period_id);
    }
}
