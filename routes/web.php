<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('students', StudentController::class);
Route::resource('room-types', RoomTypeController::class)->except('show');
Route::resource('rooms', RoomController::class);
Route::resource('assignments', AssignmentController::class);
Route::resource('payments', PaymentController::class)->except('show');