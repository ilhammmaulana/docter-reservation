<?php

use App\Http\Controllers\WEB\Admin\DocterController;
use App\Http\Controllers\WEB\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WEB\PageController;
use App\Http\Controllers\WEB\HomeController;
use App\Http\Controllers\WEB\Docter\LoginController as DocterLoginController;
use App\Http\Controllers\WEB\Admin\LoginController as AdminLoginController;
use App\Http\Controllers\WEB\UserProfileController;
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

Route::get('/404', function () {
    return view('pages.404');
})->name('404');

Route::middleware(["guest"])->group(function () {
    Route::get('/login', [DocterLoginController::class, 'show'])->name('docter.login-form');
    Route::post('/login', [DocterLoginController::class, 'login'])->name('docter.login');
    Route::prefix('admin')->group(function () {
        Route::get('/login', [AdminLoginController::class, 'show'])->name('admin.login-form');
        Route::post('/login', [AdminLoginController::class, 'login'])->name('admin.login');
    });
});


Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('home');
    Route::middleware(['role:admin'])->prefix('admins')->group(function () {
        Route::resource('user-managements', UserManagementController::class)->names('user-managements');
        Route::resource('/', AdminController::class)->names('admins');
        Route::resource('docters', DocterController::class)->names('docters');
    });
    Route::get('/virtual-reality', [PageController::class, 'vr'])->name('virtual-reality');
    Route::get('/rtl', [PageController::class, 'rtl'])->name('rtl');
    Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
    Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
    Route::post('logout', [AdminLoginController::class, 'logout'])->name('logout');
});

Route::fallback(function () {
    if (!request()->is('public/*')) {
        return redirect()->route('docter.login-form');
    }
    abort(404);
});
