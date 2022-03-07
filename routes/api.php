<?php

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


Route::group(['middleware' => ['authCheckManual']], function() {
    Route::get('games', [App\Http\Controllers\api\ApiController::class, 'games']);
    Route::get('events/{game_id?}', [App\Http\Controllers\api\ApiController::class, 'events']);
    Route::post('stadiums', [App\Http\Controllers\api\ApiController::class, 'stadiums']);
    Route::post('today_match_list', [App\Http\Controllers\api\ApiController::class, 'today_match_list']);
    Route::post('teams', [App\Http\Controllers\api\ApiController::class, 'teams']);
    Route::post('wallpapers', [App\Http\Controllers\api\ApiController::class, 'wallpapers']);
    Route::post('winners', [App\Http\Controllers\api\ApiController::class, 'winners']);
    Route::post('highlights', [App\Http\Controllers\api\ApiController::class, 'highlights']);
    Route::post('point_table', [App\Http\Controllers\api\ApiController::class, 'point_table']);
    Route::post('award_list', [App\Http\Controllers\api\ApiController::class, 'award_list']);
    Route::post('award_list_details', [App\Http\Controllers\api\ApiController::class, 'award_list_details']);
});
