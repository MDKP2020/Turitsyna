<?php

use App\Http\Controllers\ExpulsionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/expulsion-api/createList', [ExpulsionController::class, 'createExpulsionList']);

Route::post('/expulsion-api/expulsion', [ExpulsionController::class, 'expulsion']);
