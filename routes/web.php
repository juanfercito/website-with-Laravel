<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Auth controllers
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;


// Adding the controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\ShippingController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
    Route::resource('providers', ProviderController::class);
    Route::resource('shipping', ShippingController::class);
});

// Define auth routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/forgot-password', [PasswordController::class, 'forgotPassword'])->name('password.email');
Route::post('/reset-password', [PasswordController::class, 'resetPassword'])->name('password.update');
Route::post('/forgot-password', [ForgotPasswordController::class, 'forgotPassword'])->name('password.email');
Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])->name('password.update');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Route::get('products', 'App\Http\Controllers\RelationshipController@index');
