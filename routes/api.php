<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\EventFormController;

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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('login', [AuthController::class, "login"]);

Route::get('logout', [AuthController::class, "logout"])->middleware('auth:api');
Route::get('getUser', [AuthController::class, "getUSer"])->middleware(['auth:api']);

Route::apiResource('form', FormController::class)->middleware('auth:api');

Route::apiResource('question', QuestionController::class)->middleware('auth:api');

Route::apiResource('option', OptionController::class)->middleware('auth:api');

Route::apiResource('event', EventController::class)->middleware('auth:api');

Route::get('event-form/{form}', [EventFormController::class, "form"])->middleware('auth:api');
Route::post('event-form', [EventFormController::class, "save"])->middleware('auth:api');

Route::any('/', function(){
    return response()->json([
        'error' => 'Bad Request'
    ], 400);
})->name('error');