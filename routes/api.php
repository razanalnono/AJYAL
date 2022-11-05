<?php

use App\Models\Admin;
use App\Models\Course;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\InfoController;

use App\Http\Controllers\API\NewsController;


use App\Http\Controllers\API\PageController;
use App\Http\Controllers\API\SocialController;
use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\OurWorkController;
use App\Http\Controllers\API\ProgramsController;
use App\Http\Controllers\API\NewsletterController;
use App\Http\Controllers\API\LandingPageController;
use App\Http\Controllers\API\Dashboard\AdminController;
use App\Http\Controllers\API\Dashboard\CourseController;
use App\Http\Controllers\API\Dashboard\GroupsController;
use App\Http\Controllers\API\Auth\AccessTokensController;
use App\Http\Controllers\API\Dashboard\TraineeController;
use App\Http\Controllers\API\Dashboard\TrainerController;
use App\Http\Controllers\API\Dashboard\ProjectsController;
use App\Http\Controllers\Api\GlobalNotificationController;
use App\Http\Controllers\API\Dashboard\AchievementsController;

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
Route::post('/changePassword/{type}', [AccessTokensController::class, 'changePassword']);
Route::post('logout/{id}',[AccessTokensController::class,'logout']);

//Route::post('/verify', [AccessTokensController::class, 'verify']);


Route::group(['prefix' => '/dashboard'], function () {
    Route::apiResource('/admin', AdminController::class);
    Route::post('/admin/{admin}', [AdminController::class,'update']);

    Route::apiResource('/trainee', TraineeController::class);
    Route::post('/trainee/{trainee}', [TraineeController::class,'update']);

    Route::apiResource('/trainer', TrainerController::class);
    Route::post('/trainer/{trainer}', [TrainerController::class,'update']);

});
Route::middleware('auth:sanctum')->apiResource('/courses',CourseController::class)->except('index');

Route::middleware('auth:sanctum')->apiResource('/news', NewsController::class)->except('index');
Route::middleware('auth:sanctum')->post('/news/{news}', [NewsController::class, 'update']);


Route::middleware('auth:sanctum')->apiResource('/page', PageController::class)->except('index');
Route::middleware('auth:sanctum')->post('/page/{page}', [PageController::class, 'update']);

Route::apiResource('/ourWork',OurWorkController::class);
Route::post('/ourWork/{work}',[OurWorkController::class,'update']);

Route::middleware('auth:sanctum')->apiResource('/contact', ContactController::class)->except('index');
Route::middleware('auth:sanctum')->apiResource('/info', InfoController::class)->except('index');

Route::middleware('auth:sanctum')->apiResource('/programs', ProgramsController::class)->except('index');
Route::middleware('auth:sanctum')->post('/programs/{program}', [ProgramsController::class, 'update']);

Route::middleware('auth:sanctum')->apiResource('/social', SocialController::class)->except('index');
Route::middleware('auth:sanctum')->post('/social/{social}', [SocialController::class, 'update']);

Route::middleware('auth:sanctum')->apiResource('/projects', ProjectsController::class)->except('index');

Route::middleware('auth:sanctum')->apiResource('/groups', GroupsController::class)->except('index');

Route::get('LandingPage',[LandingPageController::class,'index']);

Route::middleware('auth:sanctum')->post('/deleteTraineeFromGroup', [GroupsController::class, 'destroyTrainees']);
Route::middleware('auth:sanctum')->apiResource('/achievements', AchievementsController::class)->except('index');
Route::middleware('auth:sanctum')->apiResource('/newsletter',NewsletterController::class)->except('index');

Route::post('/send_notification', [GlobalNotificationController::class, 'send']);