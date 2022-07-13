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
    Artisan::call('route:cache');
});
Route::get('/config_cache', function() {
    Artisan::call('config:cache');
});
Route::get('/storage_link', function() {
    Artisan::call('storage:link');
});


Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

Auth::routes(['register' => false,]);
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

    Route::get('users/list_data', [App\Http\Controllers\UserController::class, 'list_data']);
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::post('users/validation', [App\Http\Controllers\UserController::class,'validation']);

    Route::get('playerRoles/list_data', [App\Http\Controllers\PlayerRoleController::class, 'list_data']);
    Route::post('playerRoles/validation', [App\Http\Controllers\PlayerRoleController::class,'validation']);
    Route::resource('playerRoles', App\Http\Controllers\PlayerRoleController::class);
    Route::get('playerRoles/roleByGame/{game_id}', [App\Http\Controllers\PlayerRoleController::class, 'roleByGame']);


    Route::get('events/list_data', [App\Http\Controllers\EventController::class, 'list_data']);
    Route::post('events/validation', [App\Http\Controllers\EventController::class,'validation']);
    Route::resource('events', App\Http\Controllers\EventController::class);
    Route::get('events/eventsBYGame/{game_id}', [App\Http\Controllers\EventController::class, 'eventsBYGame']);

    Route::get('events/{event_id}/eventPointTables_edit', [App\Http\Controllers\EventController::class,'eventPointTables_edit']);
    Route::post('events/{event_id}/eventPointTables_validation', [App\Http\Controllers\EventController::class,'eventPointTables_validation']);
    Route::put('events/{event_id}/eventPointTables_update', [App\Http\Controllers\EventController::class,'eventPointTables_update']);

    Route::get('events/{event_id}/eventTeams/list_data', [App\Http\Controllers\EventTeamController::class, 'list_data']);
    Route::post('events/{event_id}/eventTeams/validation', [App\Http\Controllers\EventTeamController::class,'validation']);
    Route::resource('events/{event_id}/eventTeams', App\Http\Controllers\EventTeamController::class);

    Route::get('events/{event_id}/eventTeams/{event_team_id}/eventTeamPlayers/list_data', [App\Http\Controllers\EventTeamPlayerController::class, 'list_data']);
    Route::post('events/{event_id}/eventTeams/{event_team_id}/eventTeamPlayers/validation', [App\Http\Controllers\EventTeamPlayerController::class,'validation']);
    Route::resource('events/{event_id}/eventTeams/{event_team_id}/eventTeamPlayers', App\Http\Controllers\EventTeamPlayerController::class);
    Route::get('eventTeamPlayers/eventTeamPlayersByEvent/{event_id}', [App\Http\Controllers\EventTeamPlayerController::class, 'eventTeamPlayersByEvent']);

    Route::get('teams/list_data', [App\Http\Controllers\TeamController::class, 'list_data']);
    Route::post('teams/validation', [App\Http\Controllers\TeamController::class,'validation']);
    Route::resource('teams', App\Http\Controllers\TeamController::class);
    // Route::get('teams/{team}/editTeamPlayer', [App\Http\Controllers\TeamController::class,'editTeamPlayer']);
    // Route::post('teams/teamPlayerValidation', [App\Http\Controllers\TeamController::class,'teamPlayerValidation']);
    // Route::post('teams/{team}/updateTeamPlayer', [App\Http\Controllers\TeamController::class,'updateTeamPlayer']);
    Route::get('teams/teamsByEvent/{event_id}', [App\Http\Controllers\TeamController::class, 'teamsByEvent']);

    Route::get('players/list_data', [App\Http\Controllers\PlayerController::class, 'list_data']);
    Route::post('players/validation', [App\Http\Controllers\PlayerController::class,'validation']);
    Route::resource('players', App\Http\Controllers\PlayerController::class);

    Route::get('stadiums/list_data', [App\Http\Controllers\StadiumController::class, 'list_data']);
    Route::post('stadiums/validation', [App\Http\Controllers\StadiumController::class,'validation']);
    Route::resource('stadiums', App\Http\Controllers\StadiumController::class);
    Route::get('stadiums/stadiumsByEvent/{event_id}', [App\Http\Controllers\StadiumController::class, 'stadiumsByEvent']);

    Route::get('matches/list_data', [App\Http\Controllers\MatchController::class, 'list_data']);
    Route::post('matches/validation', [App\Http\Controllers\MatchController::class,'validation']);
    Route::resource('matches', App\Http\Controllers\MatchController::class);
    Route::get('matches/{match}/editHighlight', [App\Http\Controllers\MatchController::class,'editHighlight']);
    Route::post('matches/validationHighlight', [App\Http\Controllers\MatchController::class,'validationHighlight']);
    Route::post('matches/{match}/updateHighlight', [App\Http\Controllers\MatchController::class,'updateHighlight']);

    Route::get('eventAwards/list_data', [App\Http\Controllers\EventAwardController::class, 'list_data']);
    Route::post('eventAwards/validation', [App\Http\Controllers\EventAwardController::class,'validation']);
    Route::resource('eventAwards', App\Http\Controllers\EventAwardController::class);
    Route::get('eventAwards/eventAwardsByEvent/{event_id}', [App\Http\Controllers\EventAwardController::class, 'eventAwardsByEvent']);
    
    Route::get('eventAwardHolders/list_data', [App\Http\Controllers\EventAwardHolderController::class, 'list_data']);
    Route::post('eventAwardHolders/validation', [App\Http\Controllers\EventAwardHolderController::class,'validation']);
    Route::resource('eventAwardHolders', App\Http\Controllers\EventAwardHolderController::class);

    Route::get('eventWallpapers/list_data', [App\Http\Controllers\EventWallpaperController::class, 'list_data']);
    Route::post('eventWallpapers/validation', [App\Http\Controllers\EventWallpaperController::class,'validation']);
    Route::resource('eventWallpapers', App\Http\Controllers\EventWallpaperController::class);

    Route::get('applications/list_data', [App\Http\Controllers\ApplicationController::class, 'list_data']);
    Route::post('applications/validation', [App\Http\Controllers\ApplicationController::class,'validation']);
    Route::resource('applications', App\Http\Controllers\ApplicationController::class);

    Route::get('applicationWallpapers/list_data', [App\Http\Controllers\ApplicationWallpaperController::class, 'list_data']);
    Route::post('applicationWallpapers/validation', [App\Http\Controllers\ApplicationWallpaperController::class,'validation']);
    Route::resource('applicationWallpapers', App\Http\Controllers\ApplicationWallpaperController::class);

    Route::get('applicationVideos/list_data', [App\Http\Controllers\ApplicationVideoController::class, 'list_data']);
    Route::post('applicationVideos/validation', [App\Http\Controllers\ApplicationVideoController::class,'validation']);
    Route::resource('applicationVideos', App\Http\Controllers\ApplicationVideoController::class);

    Route::get('eventWinners/list_data', [App\Http\Controllers\EventWinnerController::class, 'list_data']);
    Route::post('eventWinners/validation', [App\Http\Controllers\EventWinnerController::class,'validation']);
    Route::resource('eventWinners', App\Http\Controllers\EventWinnerController::class);

    Route::get('configs', [App\Http\Controllers\ConfigController::class,'index']);
    Route::post('configs/validation', [App\Http\Controllers\ConfigController::class,'validation']);
    Route::post('configs/update', [App\Http\Controllers\ConfigController::class,'update']);
    // Route::resource('configs', App\Http\Controllers\ConfigController::class);

    Route::get('notifications', [App\Http\Controllers\NotificationController::class,'index']);
    Route::post('notifications/validation', [App\Http\Controllers\NotificationController::class,'validation']);
    Route::post('notifications/update', [App\Http\Controllers\NotificationController::class,'update']);
});

Route::get('notification', function () {
    return view('notification');
});


