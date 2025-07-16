<?php

use App\Http\Controllers\BonusController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\JobTitleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResources([
    'employees' => EmployeeController::class,
    'job_titles' => JobTitleController::class,
    'bonuses' => BonusController::class
    ]
);
