<?php

use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\StudentLoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::controller(StudentLoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login')->name('login.submit');
    Route::post('/logout', 'logout')->middleware('auth')->name('logout');
});

Route::controller(StudentDashboardController::class)->middleware('auth')->group(function () {
    Route::get('/student/dashboard', 'index')->name('student.dashboard');
    Route::get('/student/form', 'showForm')->name('student.form');
    Route::post('/student/form', 'submitForm')->name('student.form.submit');
});
