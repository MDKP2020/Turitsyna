<?php

use App\Http\Controllers\EnrollmentController;
use App\Models\Group;
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

Route::get('/enrollment', [EnrollmentController::class, 'indexPage'])->name('majors.index');
Route::get('/enrollment/create', [EnrollmentController::class, 'createPage'])->name('majors.create');
Route::post('/enrollment/create', [EnrollmentController::class, 'createFromForm'])->name('majors.createFromForm');

Route::get('/db', function () {

});
