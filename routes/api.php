<?php

use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\PageController;
use App\Http\Controllers\API\InfoController;
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
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/page', PageController::class);
Route::apiResource('/contact', ContactController::class);
Route::apiResource('/info', InfoController::class);