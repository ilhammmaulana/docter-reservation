<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\CategoryProductController;
use App\Http\Controllers\API\FavoriteController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ReviewController;
use Illuminate\Http\Request;
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
    Route::resource('categories', CategoryProductController::class)->only('index');
    Route::prefix('products/favorite')->group(function () {
        Route::get('/', [FavoriteController::class, 'index']);
        Route::post('/', [FavoriteController::class, 'store']);
    });
    Route::resource('products', ProductController::class)->only('index', 'show');
    Route::prefix('products/rating')->group(function () {
        Route::post('/', [ReviewController::class, 'store']);
    });
    Route::prefix('products/categories')->group(function () {
        Route::get('/{id}', [ProductController::class, 'getByCategory']);
    });
    Route::resource('carts', CartController::class)->only('index', 'store', 'update', 'destroy');
    Route::prefix('carts')->group(function () {
        Route::post('decrement', [CartController::class, 'decrement']);
        Route::post('increment', [CartController::class, 'increment']);
    });
    Route::resource('orders', OrderController::class)->only('index', 'show', 'store');
    Route::prefix('orders')->group(function () {
    });
});
