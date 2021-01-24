<?php

use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\ExpulsionController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TransferController;
use App\Models\Group;
use App\Models\Student;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('welcome');
});

//Зачисление
Route::post('/enrollment-api/addStudent', [EnrollmentController::class, 'addStudentToGroup']);
Route::delete('/enrollment-api/delStudFromGroup/{student_id}/{group_id}', [EnrollmentController::class, 'deleteStudentFromGroup']);
Route::post('/enrollment-api/changeStudGroup/{student_id}/{old_group_id}/{new_group_id}', [EnrollmentController::class, 'changeStudentsGroup']);
Route::get('/enrollment-api/checkEmptyGroups', [EnrollmentController::class, 'checkEmptyGroups']);

//Отчисление
Route::get('/expulsion-api/createList', [ExpulsionController::class, 'createExpulsionList']);
Route::post('/expulsion-api/student/{student_id}', [ExpulsionController::class, 'expulsionStudent']);
Route::post('/expulsion-api/group/{group_id}', [ExpulsionController::class, 'expulsionGroup']);
Route::post('/expulsion-api/graduates', [ExpulsionController::class, 'expulsionGraduates']);

//Перевод
Route::get('/transfer-api/createList', [TransferController::class, 'createTransferList']);
Route::post('/transfer-api/transfer', [TransferController::class, 'transferStudents']);

//Студенты
Route::get('/student-api/getStudent', [StudentController::class, 'getStudentByFIO']);
Route::get('/student-api/getStudentsFromGroup/{group_id}', [StudentController::class, 'getStudentsFromGroup']);
Route::get('/student-api/getGroupStudentsList', [StudentController::class, 'getStudentsAndGroups']);

//Группы и прочее
Route::post('/group-api/create', [GroupController::class, 'createGroup']);
Route::get('/group-api/getGroup/{name}/{study_year_id}', [GroupController::class, 'getGroupByNameYear']);
Route::get('/group-api/getDirection/{name}', [GroupController::class, 'getDirectionByName']);
Route::get('/group-api/getStudyYear/{year}', [GroupController::class, 'getStudyYearByYear']);
Route::get('/group-api/getLeveEduc/{name}', [GroupController::class, 'getLevelEducation']);
Route::post('/group-api/changeGroupName/{group_id}/{name}', [GroupController::class, 'changeGroupName']);
