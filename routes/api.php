<?php

use App\Http\Controllers\API\Auth\AccessTokensController;
use App\Http\Controllers\API\Dashboard\AdminController;
use App\Http\Controllers\API\Dashboard\CourseController;
use App\Http\Controllers\API\Dashboard\TraineeController;
use App\Http\Controllers\API\Dashboard\TrainerController;
use App\Http\Controllers\API\PageController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\NewsController;
use App\Models\Admin;
use App\Models\page;
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
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

 Route::apiResource('/page',PageController::class);


Route::post('/login/{type}',[AccessTokensController::class,'login']);
Route::post('/verify',[AccessTokensController::class,'verify']);
// Route::prefix('/dashboard')->function({
//    Route::apiResource('/admin',AdminController::class); 
// });

Route::group(['prefix' => '/dashboard'], function () {
      Route::apiResource('/admin',AdminController::class); 
      Route::apiResource('/trainee',TraineeController::class);
      Route::apiResource('/trainer',TrainerController::class);
});
Route::apiResource('courses',CourseController::class);

Route::post('/images',[NewsController::class,'store']);
Route::post('/images/{news}', [NewsController::class, 'update']);

Route::get('/news',[NewsController::class,'index']);