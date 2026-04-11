<?php

use App\Http\Controllers\PaymentController;
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
    Route::get('/student/download-form', 'downloadForm')->name('student.download-form');
});

Route::controller(PaymentController::class)->middleware('auth')->group(function () {
    Route::get('/init-payment/{id}', 'initPayment')->name('payment.init');
    Route::get('/confirm-payment/{id}', 'confirmPayment')->name('payment.confirm');
});
