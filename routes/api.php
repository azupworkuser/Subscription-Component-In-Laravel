<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\WebsiteController;
use App\Http\Controllers\API\WebsitePostController;
use App\Http\Controllers\API\WebsiteSubscriptionController;

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


Route::apiResource('/website', WebsiteController::class)->only(['index']);
Route::get('/post/{website}', [WebsitePostController::class, 'index']);
Route::post('/post/{website}', [WebsitePostController::class, 'store']);
Route::put('/post/{id}', [WebsitePostController::class, 'update']);
Route::post('/subscription/{website}/{user}', [WebsiteSubscriptionController::class, 'store']);
