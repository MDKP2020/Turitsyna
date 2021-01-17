<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\GroupController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Period
Route::post('/changePeriod/{new_period}', [Controller::class, 'changeSystemPeriod']);

//Groups
Route::get('/group', [GroupController::class, 'getAllGroups']);

Route::get('/group/{id}', [GroupController::class, 'getGroup']);

Route::post('/group/changeGroupName', [GroupController::class, 'changeGroupName']);

Route::get('/group/getStudentsList/{group_id}', [GroupController::class, 'getListOfStudents']);
