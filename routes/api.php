<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\CategoryProductController;
use App\Http\Controllers\API\DocterCategoryController;
use App\Http\Controllers\API\DocterController;
use App\Http\Controllers\API\FavoriteController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ReservationController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\API\SavedDocterController;
use App\Http\Controllers\API\PromoBannerController;
use App\Http\Controllers\API\SubdistrictController;
use App\Http\Controllers\API\NotificationController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/refresh', [AuthController::class, 'refresh'])->middleware('auth.refresh');
Route::post('/auth/register', [AuthController::class, 'register']);
Route::resource('subdistricts', SubdistrictController::class)->only('index');


Route::middleware([
    'auth.api'
])->group(function () {
    Route::group([
        'prefix' => 'auth'
    ], function () {
        Route::delete('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
        Route::post('change-password', [AuthController::class, 'updatePassword']);
    });
    Route::group([
        'prefix' => 'user'
    ], function () {
        Route::post('profile', [AuthController::class, 'update']);
    });
    Route::resource('reservations', ReservationController::class)->only('index', 'store', 'show')->names('api-reservations');
    Route::prefix('docters')->group(function () {
        Route::get('history', [DocterController::class, 'historyDocter']);
        Route::resource('saved', SavedDocterController::class)->only('index', 'store');
        Route::resource('categories', DocterCategoryController::class)->only('index', 'show');
        Route::controller(DocterController::class)->group(function () {
            Route::get('subdistricts/{id}', 'filterBySubdistrict');
            Route::get('filter', 'filterDocter');
        });
    });
    Route::resource('promo-banners', PromoBannerController::class)->only('index', 'store', 'destroy');

    Route::prefix('promo-banners')->group(function () {
        Route::post('/update/{id}', [PromoBannerController::class,'update']);
    });

    Route::resource('docters', DocterController::class)->only('index', 'show')->names('api-docters');
});

Route::group([
    "prefix" => "dev",
], function () {
    Route::post('notification', [NotificationController::class, 'sendNotificationDevelopment']);
});

