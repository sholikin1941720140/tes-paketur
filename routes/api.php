<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\SuperAdmin\SuperAdminController;
use App\Http\Controllers\API\SuperAdmin\SuperAdminProfileController;
use App\Http\Controllers\API\Manager\ManagerUserController;
use App\Http\Controllers\API\Manager\ManagerProfileController;
use App\Http\Controllers\API\Employee\EmployeeController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::middleware('superadmin')->group(function () {
        Route::get('/superadmin', [SuperAdminController::class, 'index']);
        Route::post('/superadmin/store', [SuperAdminController::class, 'store']);
        Route::delete('/superadmin/delete/{id}', [SuperAdminController::class, 'destroy']);
    
        Route::get('/superadmin-profile', [SuperAdminProfileController::class, 'index']);
        Route::put('/superadmin-profile/update', [SuperAdminProfileController::class, 'update']);
    });

    Route::middleware('manager')->group(function () {
        Route::get('/manager', [ManagerUserController::class, 'index']);
        Route::post('/manager/store', [ManagerUserController::class, 'store']);
        Route::get('/manager/detail/{id}', [ManagerUserController::class, 'show']);
        Route::put('/manager/update/{id}', [ManagerUserController::class, 'update']);
        Route::delete('/manager/delete/{id}', [ManagerUserController::class, 'destroy']);

        Route::get('/manager/profile', [ManagerProfileController::class, 'index']);
        Route::put('/manager/profile/update', [ManagerProfileController::class, 'update']);
    });

    Route::middleware('employee')->group(function () {
        Route::get('/employee', [EmployeeController::class, 'index']);
        Route::get('/employee/detail/{id}', [EmployeeController::class, 'show']);

        Route::get('/employee/profile', [EmployeeController::class, 'profile']);
    });
});