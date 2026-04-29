<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\StudentLoginController;
use App\Models\Setting;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $settings = Setting::all()->pluck('value', 'key')->toArray();
    return view('welcome', compact('settings'));
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
    Route::get('/student/form/edit', 'edit')->name('student.form.edit');
    Route::put('/student/form/update', 'update')->name('student.form.update');
    Route::get('/student/download-form', 'downloadForm')->name('student.download-form');
});

Route::controller(PaymentController::class)->middleware('auth')->group(function () {
    Route::get('/init-payment/{id}', 'initPayment')->name('payment.init');
    Route::get('/confirm-payment/{id}', 'confirmPayment')->name('payment.confirm');
});


//admin routes
Route::prefix('admin')->controller(AdminController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('admin.login');
    Route::post('/login', 'login')->name('admin.login.submit');
    Route::post('/logout', 'logout')->middleware('auth')->name('admin.logout');
});

Route::prefix('admin')->controller(AdminController::class)->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', 'dashboard')->name('admin.dashboard');
    Route::get('/bug-fix', 'bugFix')->name('admin.bug-fix');
});
