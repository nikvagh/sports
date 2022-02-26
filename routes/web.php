<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/clear_cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('config:clear');
    return "All cache cleared";
});
Route::get('/cache_config_clear', function() {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    return "All cache cleared";
});
Route::get('/cache_clear', function() {
    Artisan::call('cache:clear');
});
Route::get('/view_cache', function() {
    Artisan::call('view:clear');
});
Route::get('/route_clear', function() {
    Artisan::call('route:clear');
});
Route::get('/config_cache', function() {
    Artisan::call('config:cache');
});


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth','prefix' => admin()], function ($router) {
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index']);
    
    Route::post('profile/validation', [App\Http\Controllers\ProfileController::class,'validation']);
    Route::get('/edit-profile', [App\Http\Controllers\ProfileController::class, 'edit']);
    Route::post('profile/{user}', [App\Http\Controllers\ProfileController::class, 'update']);

    Route::get('change-password', [App\Http\Controllers\ProfileController::class, 'changePassword']);
    Route::post('change-password/validation', [App\Http\Controllers\ProfileController::class,'changePasswordValidation']);
    Route::post('change-password/{user}', [App\Http\Controllers\ProfileController::class, 'changePasswordUpdate']);

    Route::get('games/list_data', [App\Http\Controllers\GameController::class, 'list_data']);
    Route::resource('games', App\Http\Controllers\GameController::class);
    Route::post('games/validation', [App\Http\Controllers\GameController::class,'validation']);

    Route::get('events/list_data', [App\Http\Controllers\EventController::class, 'list_data']);
    Route::post('events/validation', [App\Http\Controllers\EventController::class,'validation']);
    Route::resource('events', App\Http\Controllers\EventController::class);
    
});

