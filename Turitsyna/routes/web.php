<?php

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
    return null;
});
