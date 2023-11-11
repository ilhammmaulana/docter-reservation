<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WEB\HomeController;
use App\Http\Controllers\WEB\PageController;
use App\Http\Controllers\WEB\AdminController;
use App\Http\Controllers\WEB\DocterImageController;
use App\Http\Controllers\WEB\ReservationController;
use App\Http\Controllers\WEB\UserProfileController;
use App\Http\Controllers\WEB\Admin\DocterController;
use App\Http\Controllers\WEB\UserManagementController;
use App\Http\Controllers\WEB\Admin\LoginController as AdminLoginController;
use App\Http\Controllers\WEB\Docter\LoginController as DocterLoginController;

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
    Route::resource('admins', AdminController::class)->only('index', 'store', 'update', 'destroy')->names('admins')->middleware('role:admin');
    Route::middleware(['role:admin'])->prefix('admins')->group(function () {
        Route::resource('user-managements', UserManagementController::class)->names('user-managements');
        Route::resource('docters', DocterController::class)->names('docters');
    });
    Route::middleware(['docter'])->prefix('docters')->group(function () {
        Route::resource('reservations', ReservationController::class)->names('reservations');
        Route::get('history/reservation', [ReservationController::class, 'history'])->name('reservations.history');
        Route::prefix('reservations')->group(function () {
            Route::post('verify/{id}', [ReservationController::class, 'verify'])->name('reservations.verify');
            Route::post('cancel/{id}', [ReservationController::class, 'cancel'])->name('reservations.cancel');
            Route::post('arrived/{id}', [ReservationController::class, 'arrived'])->name('reservations.arrived');
            Route::post('done/{id}', [ReservationController::class, 'done'])->name('reservations.done');
        });
        Route::prefix('docters')->group(function () {
            Route::post('/update-operation', [DocterController::class, 'updateOpration'])->name('docters.update-opration');
        });
    });
    
    Route::resource('docter-images', DocterImageController::class)->names('docter-images');
    // Route::prefix('docter-images')->group(function () {
    //     Route::post('/', [DocterImageController::class, 'store']);
    // });
    Route::get('/virtual-reality', [PageController::class, 'vr'])->name('virtual-reality');
    Route::get('/rtl', [PageController::class, 'rtl'])->name('rtl');
    Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
    Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
    Route::post('logout', [AdminLoginController::class, 'logout'])->name('logout');
});

Route::fallback(function () {
    if (request()->is('api/*')) {
        return response()->json([
            'status' => 404,
            'message' => 'URL Not found!',
        ], 404);
    } else {
        return redirect()->route('docter.login-form');
    }
});
