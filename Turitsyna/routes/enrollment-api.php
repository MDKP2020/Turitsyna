<?php

use App\Http\Controllers\EnrollmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::get('/enrollment-api/period', [EnrollmentController::class, 'isEnrolmentPeriod']);

Route::post('/enrollment-api/addStud', [EnrollmentController::class, 'addStudentToGroup']);

Route::delete('/enrollment-api/delStudFromGroup/{student_id}/{group_id}', [EnrollmentController::class, 'deleteStudentFromGroup']);

Route::post('/enrollment-api/changeStudGroup/{student_id}/{old_group_id}/{new_group_id}', [EnrollmentController::class, 'changeStudentsGroup']);

Route::get('/enrollment-api/checkEmptyGroups', [EnrollmentController::class, 'checkEmptyGroups']);
