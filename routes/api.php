<?php

namespace App\Http\Controllers\Api;

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

Route::post('register', [AuthController::class, 'register']);
Route::match(['get', 'post'], 'login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/', [TendersApiController::class, 'index']);
    Route::get('/code/{id}', [TendersApiController::class, 'tender']);
    Route::get('/query/{string}', [TendersApiController::class, 'filter_tenders'])->where('string', '.*');
    Route::post('/add/', [TendersApiController::class, 'add_tender']);
});