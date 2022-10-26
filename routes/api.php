<?php

use App\Http\Controllers\API\Auth\AccessTokensController;
use App\Http\Controllers\API\Dashboard\AdminController;
use App\Http\Controllers\API\Dashboard\TraineeController;
use App\Http\Controllers\API\Dashboard\TrainerController;

use App\Http\Controllers\NewsController;


use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\Dashboard\AchievementsController;
use App\Http\Controllers\API\Dashboard\GroupsController;
use App\Http\Controllers\API\Dashboard\ProjectsController;
use App\Http\Controllers\API\PageController;
use App\Http\Controllers\API\InfoController;
use App\Http\Controllers\API\ProgramsController;
use App\Http\Controllers\API\SocialController;
use App\Http\Controllers\OurWorkController;
use App\Models\Admin;
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

Route::apiResource('/page', PageController::class);



Route::post('/login/{type}', [AccessTokensController::class, 'login']);
//Route::post('/verify', [AccessTokensController::class, 'verify']);


Route::group(['prefix' => '/dashboard'], function () {
    Route::apiResource('/admin', AdminController::class);
    Route::post('/admin/{admin}', [AdminController::class,'update']);

    Route::apiResource('/trainee', TraineeController::class);
    Route::post('/trainee/{trainee}', [TraineeController::class,'update']);

    Route::apiResource('/trainer', TrainerController::class);
    Route::post('/trainer/{trainer}', [TrainerController::class,'update']);

});
Route::apiResource('courses', CourseController::class);

Route::apiResource('/news', NewsController::class);
Route::post('/news/{news}', [NewsController::class, 'update']);


Route::apiResource('/page', PageController::class);
Route::post('/page/{page}', [PageController::class, 'update']);

Route::apiResource('/ourWork',OurWorkController::class);
Route::post('/ourWork/{work}',[OurWorkController::class,'update']);

Route::apiResource('/contact', ContactController::class);
Route::apiResource('/info', InfoController::class);
Route::apiResource('/programs', ProgramsController::class);
Route::post('/programs/{program}', [ProgramsController::class, 'update']);
Route::apiResource('/social', SocialController::class);
Route::post('/social/{social}', [SocialController::class, 'update']);
Route::apiResource('/projects', ProjectsController::class);
Route::apiResource('/groups', GroupsController::class);

Route::post('/deleteTraineeFromGroup', [GroupsController::class, 'destroyTrainees']);
Route::apiResource('/achievements', AchievementsController::class);


