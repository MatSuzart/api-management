<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\WallController;
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

Route::get('/401', [AuthController::class, 'unauthorized'])->name('login');
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);

Route::middleware('auth:api')->group(function () {
    Route::post('/auth/validate', [AuthController::class, 'validateToken']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    // Mural
    Route::get('/walls', [WallController::class, 'getAll']);
    Route::post('/wall/{id}/like', [WallController::class, 'like']);



});
