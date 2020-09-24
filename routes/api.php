<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\MeController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\RegisterController;


Route::group([ 'prefix' => 'auth' ], function () {

    Route::post('signin',       [SignInController::class, 'index']);
    Route::post('signout',      [SignOutController::class, 'index']);
    Route::post('register',     [RegisterController::class, 'index']);

    Route::get('me',            [MeController::class, 'index'])->middleware(['auth:api']);

});


Route::get('questions', [QuestionController::class, 'index']);
Route::post('questions/{question}/vote', [QuestionController::class, 'vote'])->middleware(['auth:api']);
