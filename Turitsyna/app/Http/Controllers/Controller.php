<?php

namespace App\Http\Controllers;


use App\Providers\StudentGroupService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected StudentGroupService $service;
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


}
