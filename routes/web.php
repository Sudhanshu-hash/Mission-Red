<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BloodRequestController;
use App\Http\Controllers\BloodRequestResponseController;


Route::get('/', [LoginController::class, 'index'])->name('home');
/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');
Route::get('/forgot-password', [ForgotPasswordController::class, 'create'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'create'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'store'])->name('password.update');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile/create', [ProfileController::class, 'create'])->name('profile.create');
    Route::post('/profile', [ProfileController::class, 'store'])->name('profile.store');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    /*
    |--------------------------------------------------------------------------
    | Blood Requests
    |--------------------------------------------------------------------------
    */
    Route::get('/blood-requests/discover', [BloodRequestController::class, 'discover'])->name('blood-requests.discover');
    Route::get('/blood-requests', [BloodRequestController::class, 'index'])->name('blood-requests.index');
    Route::get('/blood-requests/create', [BloodRequestController::class, 'create'])->name('blood-requests.create');
    Route::post('/blood-requests', [BloodRequestController::class, 'store'])->name('blood-requests.store');
    Route::get('/blood-requests/{bloodRequest}', [BloodRequestController::class, 'show'])->name('blood-requests.show');
    Route::get('/blood-requests/{bloodRequest}/edit', [BloodRequestController::class, 'edit'])->name('blood-requests.edit');
    Route::put('/blood-requests/{bloodRequest}', [BloodRequestController::class, 'update'])->name('blood-requests.update');
    Route::delete('/blood-requests/{bloodRequest}', [BloodRequestController::class, 'destroy'])->name('blood-requests.destroy');
    /*
    |--------------------------------------------------------------------------
    | Blood Request Responses
    |--------------------------------------------------------------------------
    */
    Route::post('/blood-requests/{bloodRequest}/responses', [BloodRequestController::class, 'respond'])->name('blood-request-responses.store');
    Route::get('/blood-requests/{bloodRequest}/responses', [BloodRequestController::class, 'responses'])->name('blood-request-responses.index');
    Route::patch('/blood-requests/{bloodRequest}/responses/{response}', [BloodRequestController::class, 'updateResponse'])->name('blood-request-responses.update');
});