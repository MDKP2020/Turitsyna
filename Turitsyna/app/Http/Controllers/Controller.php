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

    // NOT NEEDED
    public static function currentPeriod(){
        return Period::where('id',StudyYear::max('start_year')->period_id);
    }

    //
    public static function currentYear(){
        return StudyYear::max('start_year')->first();
    }

    //NOT NEEDED
    public static function changeSystemPeriod(string $new_period){
        $current_year = Controller::currentYear()->id;
        $current_year->period_id = Period::all()->where("name", '=', $new_period)
            ->first()
            ->id;
        $current_year->save();
    }
}
