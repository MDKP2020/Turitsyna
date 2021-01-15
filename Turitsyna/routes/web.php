<?php

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

Route::get('/db', function () {
    //DB::insert('insert into status (name) values (?)', ['Expelled']);

    /*$gr = new Group();
    $gr->name = 'IVT-163';
    $gr->education_form = 2;
    $gr->level_education = 2;
    $gr->save();*/
    $groups = App\Models\Group::all();
    foreach ($groups as $group) {
        return $group;
    }
});

/**
 * Добавить нового студента в группу
 * */
Route::post('/enrollment/add', function ($student, $group) {

});

/**
 * Удалить студента из группы
 * */
Route::delete('/enrollment/delete/{groupId}/{studentId}', function ($groupId, $studentId) {

});

/**
 * Переместить студента из одной группы в другую
 * */
Route::patch('/enrollment/changeStudentGroup/{studentId}', function ($studentId, $prevGroupId, $newGroup) {

});

/**
 * Изменить название группы
 * */
Route::patch('/enrollment/changeGroupName/{groupId}', function ($groupId, $newGroupName) {

});

/**
 * Получить студентов по группам согласен фильтру
 */
Route::get('/getGroupStudents', function ($date, $course, $spec, $groupName) {

});

/**
 * Получить студентов, которых зачисляют на 1 курс
 */
Route::get('/enrollment/getGroupStudents', function ($spec, $groupName) {

});

/**
 * Получить предварительные составы групп, которые будут сформированы после перевода
 */
Route::get('/transfer/getNewStudentsGroups', function () {

});

/**
 * Перевести студентов на старший курс
 */
Route::patch('/transfer', function () {

});

