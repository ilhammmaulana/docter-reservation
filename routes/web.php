<?php

use App\Http\Controllers\WEB\AdminController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\WEB\PageController;
use App\Http\Controllers\WEB\RegisterController;
use App\Http\Controllers\WEB\HomeController;
use App\Http\Controllers\WEB\LoginController;
use App\Http\Controllers\WEB\UserProfileController;
use App\Http\Controllers\WEB\ResetPassword;
use App\Http\Controllers\WEB\ChangePassword;
use App\Http\Controllers\WEB\DestinationController;
use App\Http\Controllers\WEB\ProductController;
use App\Http\Controllers\WEB\UserManagementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('/register', [RegisterController::class, 'store'])->middleware('guest')->name('register.perform');
Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.perform');
Route::get('/reset-password', [ResetPassword::class, 'show'])->middleware('guest')->name('reset-password');
Route::post('/reset-password', [ResetPassword::class, 'send'])->middleware('guest')->name('reset.perform');
Route::get('/change-password', [ChangePassword::class, 'show'])->middleware('guest')->name('change-password');
Route::post('/change-password', [ChangePassword::class, 'update'])->middleware('guest')->name('change.perform');
Route::get('/dashboard', [HomeController::class, 'index'])->name('home')->middleware('auth');
Route::group(['middleware' => 'auth'], function () {
    Route::resource('products', ProductController::class)->names('products');
    Route::resource('user-managements', UserManagementController::class)->names('user-managements');
    Route::resource('admins', AdminController::class)->names('admins');
    Route::get('/virtual-reality', [PageController::class, 'vr'])->name('virtual-reality');
    Route::get('/rtl', [PageController::class, 'rtl'])->name('rtl');
    Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
    Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile-static', [PageController::class, 'profile'])->name('profile-static');
    Route::get('/sign-in-static', [PageController::class, 'signin'])->name('sign-in-static');
    Route::get('/sign-up-static', [PageController::class, 'signup'])->name('sign-up-static');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});

Route::fallback(function () {
    if (!request()->is('public/*')) {
        return redirect('/login');
    }
    abort(404);
});
