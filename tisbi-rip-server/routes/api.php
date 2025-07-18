<?php

use App\Http\Controllers\BonusController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\JobTitleController;
use App\Http\Controllers\Auth\AuthenticationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/user/login_by_token', [AuthenticationController::class, 'loginByToken']);
Route::post('/user/login_by_pass', [AuthenticationController::class, 'loginByPass']);

Route::apiResources(
    [
        'employees' => EmployeeController::class,
        'job_titles' => JobTitleController::class,
        'bonuses' => BonusController::class
    ]
);
