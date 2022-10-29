<?php

use App\Http\Controllers\API\Auth\AccessTokensController;
use App\Http\Controllers\API\Dashboard\AdminController;
use App\Http\Controllers\API\Dashboard\TraineeController;
use App\Http\Controllers\API\Dashboard\TrainerController;

use App\Http\Controllers\NewsController;


use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\Dashboard\AchievementsController;
use App\Http\Controllers\API\Dashboard\AttendencesController;
use App\Http\Controllers\API\Dashboard\GroupsController;
use App\Http\Controllers\API\Dashboard\PresenceAbsencesController;
use App\Http\Controllers\API\Dashboard\ProjectsController;
use App\Http\Controllers\API\PageController;
use App\Http\Controllers\API\InfoController;
use App\Http\Controllers\API\ProgramsController;
use App\Http\Controllers\API\SocialController;
use App\Http\Controllers\OurWorkController;
use App\Models\Admin;
use App\Models\Course;
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

Route::apiResource('/attendences', AttendencesController::class);


Route::get('get-presence_absence-for-course',[PresenceAbsencesController::class, 'index']);
Route::post('store-presence_absence-for-course',[PresenceAbsencesController::class, 'store']);
Route::put('update-presence_absence-for-course/{id}',[PresenceAbsencesController::class, 'update']);


