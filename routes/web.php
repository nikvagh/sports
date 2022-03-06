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
Route::get('/storage_link', function() {
    Artisan::call('storage:link');
});


Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

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
    Route::get('events/eventsBYGame/{game_id}', [App\Http\Controllers\EventController::class, 'eventsBYGame']);

    Route::get('events/{event_id}/eventTeams/list_data', [App\Http\Controllers\EventTeamController::class, 'list_data']);
    Route::post('events/{event_id}/eventTeams/validation', [App\Http\Controllers\EventTeamController::class,'validation']);
    Route::resource('events/{event_id}/eventTeams', App\Http\Controllers\EventTeamController::class);

    Route::get('events/{event_id}/eventTeams/{event_team_id}/eventTeamPlayers/list_data', [App\Http\Controllers\EventTeamPlayerController::class, 'list_data']);
    Route::post('events/{event_id}/eventTeams/{event_team_id}/eventTeamPlayers/validation', [App\Http\Controllers\EventTeamPlayerController::class,'validation']);
    Route::resource('events/{event_id}/eventTeams/{event_team_id}/eventTeamPlayers', App\Http\Controllers\EventTeamPlayerController::class);

    Route::get('teams/list_data', [App\Http\Controllers\TeamController::class, 'list_data']);
    Route::post('teams/validation', [App\Http\Controllers\TeamController::class,'validation']);
    Route::resource('teams', App\Http\Controllers\TeamController::class);
    // Route::get('teams/{team}/editTeamPlayer', [App\Http\Controllers\TeamController::class,'editTeamPlayer']);
    // Route::post('teams/teamPlayerValidation', [App\Http\Controllers\TeamController::class,'teamPlayerValidation']);
    // Route::post('teams/{team}/updateTeamPlayer', [App\Http\Controllers\TeamController::class,'updateTeamPlayer']);

    Route::get('players/list_data', [App\Http\Controllers\PlayerController::class, 'list_data']);
    Route::post('players/validation', [App\Http\Controllers\PlayerController::class,'validation']);
    Route::resource('players', App\Http\Controllers\PlayerController::class);

    Route::get('stadiums/list_data', [App\Http\Controllers\StadiumController::class, 'list_data']);
    Route::post('stadiums/validation', [App\Http\Controllers\StadiumController::class,'validation']);
    Route::resource('stadiums', App\Http\Controllers\StadiumController::class);

    Route::get('matches/list_data', [App\Http\Controllers\MatchController::class, 'list_data']);
    Route::post('matches/validation', [App\Http\Controllers\MatchController::class,'validation']);
    Route::resource('matches', App\Http\Controllers\MatchController::class);
    Route::get('matches/{match}/editHighlight', [App\Http\Controllers\MatchController::class,'editHighlight']);
    Route::post('matches/validationHighlight', [App\Http\Controllers\MatchController::class,'validationHighlight']);
    Route::post('matches/{match}/updateHighlight', [App\Http\Controllers\MatchController::class,'updateHighlight']);

    Route::get('eventAwards/list_data', [App\Http\Controllers\EventAwardController::class, 'list_data']);
    Route::post('eventAwards/validation', [App\Http\Controllers\EventAwardController::class,'validation']);
    Route::resource('eventAwards', App\Http\Controllers\EventAwardController::class);

    Route::get('eventWallpapers/list_data', [App\Http\Controllers\eventWallpaperController::class, 'list_data']);
    Route::post('eventWallpapers/validation', [App\Http\Controllers\eventWallpaperController::class,'validation']);
    Route::resource('eventWallpapers', App\Http\Controllers\eventWallpaperController::class);

    Route::get('applications/list_data', [App\Http\Controllers\ApplicationController::class, 'list_data']);
    Route::post('applications/validation', [App\Http\Controllers\ApplicationController::class,'validation']);
    Route::resource('applications', App\Http\Controllers\ApplicationController::class);

    Route::get('applicationWallpapers/list_data', [App\Http\Controllers\ApplicationWallpaperController::class, 'list_data']);
    Route::post('applicationWallpapers/validation', [App\Http\Controllers\ApplicationWallpaperController::class,'validation']);
    Route::resource('applicationWallpapers', App\Http\Controllers\ApplicationWallpaperController::class);

    Route::get('applicationVideos/list_data', [App\Http\Controllers\ApplicationVideoController::class, 'list_data']);
    Route::post('applicationVideos/validation', [App\Http\Controllers\ApplicationVideoController::class,'validation']);
    Route::resource('applicationVideos', App\Http\Controllers\ApplicationVideoController::class);

    Route::get('eventWinners/list_data', [App\Http\Controllers\eventWinnerController::class, 'list_data']);
    Route::post('eventWinners/validation', [App\Http\Controllers\eventWinnerController::class,'validation']);
    Route::resource('eventWinners', App\Http\Controllers\eventWinnerController::class);

    Route::get('playerRoles/list_data', [App\Http\Controllers\PlayerRoleController::class, 'list_data']);
    Route::post('playerRoles/validation', [App\Http\Controllers\PlayerRoleController::class,'validation']);
    Route::resource('playerRoles', App\Http\Controllers\PlayerRoleController::class);
});