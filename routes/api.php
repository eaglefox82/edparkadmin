<?php

use App\Http\Controllers\Api\ApiController;
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

Route::get('/events', [ApiController::class, 'getEvents']);

//Training Camp
Route::get('/trainingcamp/{eventId}/memberInspection/{certNo}', [ApiController::class, 'getMemberInspection']);
Route::post('/trainingcamp/{eventId}/memberInspection', [ApiController::class, 'storeMemberInspection']);
Route::get('/trainingcamp/{eventId}/mealSchedules', [ApiController::class, 'getMeals']);
Route::post('/trainingcamp/{eventId}/mealSchedules/checkin', [ApiController::class, 'mealCheckIn']);

//Cadet of the Year
Route::get('/cadet_comp/{eventId}/memberInspection/{certNo}', [ApiController::class, 'getCadetOfTheYearInspection']);
Route::post('/cadet_comp/{eventId}/memberInspection', [ApiController::class, 'storeCadetOfTheYearInspection']);
