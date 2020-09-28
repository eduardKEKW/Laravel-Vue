<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\MeController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\OptionController;

Route::group([ 'prefix' => 'auth' ], function () {

    Route::post('signin',   [SignInController::class, 'index']);
    Route::post('signout',  [SignOutController::class, 'index']);
    Route::post('register', [RegisterController::class, 'index']);

    Route::get('me', [MeController::class, 'index'])->middleware(['auth:api']);

});


Route::get('questions', [QuestionController::class, 'index']);

Route::post('options/{option}/vote',    [OptionController::class, 'vote'])->middleware(['auth:api']);
Route::post('options/store/{question}', [OptionController::class, 'store'])->middleware(['auth:api']);
Route::post('questions/create',         [QuestionController::class, 'store'])->middleware(['auth:api']);
