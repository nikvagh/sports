<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\ApplicationVideo;
use App\Models\ApplicationWallpaper;
use App\Models\Config;
use App\Models\DeviceToken;
use App\Models\Event;
use App\Models\EventAward;
use App\Models\EventAwardHolder;
use App\Models\EventPointTable;
use App\Models\EventTeam;
use App\Models\EventWallpaper;
use App\Models\EventWinner;
use App\Models\Game;
use App\Models\Highlight;
use App\Models\Matches;
use App\Models\Stadium;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{

    public function apiToken(){
        $result['configs'] = Config::where('name','api_token')->get()->first();
        return response()->json(['status' => 200, 'title' => 'success', "result" => $result]);
    }

    public function games(){
        $result['games'] = Game::all();
        return response()->json(['status' => 200, 'title' => 'success', "result" => $result]);
    }

    public function events($game_id=0){
        $events = Event::where('id','>',0);
        if($game_id > 0){
            $events = $events->where('game_id',$game_id)->get()->all();
        }else{
            $events = $events->get()->all();
        }
        $result['events'] = $events;
        return response()->json(['status' => 200, 'title' => 'success', "result" => $result]);
    }

    public function stadiums(){
        $validator = Validator::make(request()->all(), [
            'event_id' => 'required'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'title' => $validator->errors()->first()]);
        }

        extract(request()->all());

        $stadiums = Stadium::where('event_id',$event_id)->get()->all();
        $result['stadiums'] = $stadiums;
        return response()->json(['status' => 200, 'title' => 'success', "result" => $result]);
    }

    public function today_match_list(){
        $validator = Validator::make(request()->all(), [
            'event_id' => 'required'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'title' => $validator->errors()->first()]);
        }

        extract(request()->all());
        // curr_date();

        $matches = Matches::select('matches.*')
                            ->leftJoin('event_teams AS t1','t1.id','=','matches.event_team_id_1')
                            ->leftJoin('event_teams AS t2','t2.id','=','matches.event_team_id_2')
                            ->where('t1.event_id',$event_id)
                            ->whereDate('matches.match_time',curr_date())
                            ->with('team1')
                            ->with('team2')
                            ->get()->all();
        $result['matches'] = $matches;
        return response()->json(['status' => 200, 'title' => 'success', "result" => $result]);
    }

    public function teams(){
        $validator = Validator::make(request()->all(), [
            'event_id' => 'required'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'title' => $validator->errors()->first()]);
        }

        extract(request()->all());
        // curr_date();

        $EventTeams = EventTeam::where('event_id',$event_id)->with('team')->with('eventTeamPlayers')->with('eventTeamPlayers.player')->with('eventTeamPlayers.player.playerRole')->get()->all();
        $result['teams'] = $EventTeams;
        return response()->json(['status' => 200, 'title' => 'success', "result" => $result]);
    }

    public function wallpapers(){
        $validator = Validator::make(request()->all(), [
            'event_id' => 'required'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'title' => $validator->errors()->first()]);
        }

        extract(request()->all());
        // curr_date();

        $wallpapers = EventWallpaper::where('event_id',$event_id)->get()->all();
        $result['wallpapers'] = $wallpapers;
        return response()->json(['status' => 200, 'title' => 'success', "result" => $result]);
    }

    public function winners(){
        $validator = Validator::make(request()->all(), [
            'event_id' => 'required'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'title' => $validator->errors()->first()]);
        }

        extract(request()->all());
        // curr_date();

        $winners = EventWinner::where('event_id',$event_id)->with('team')->get()->all();
        $result['winners'] = $winners;
        return response()->json(['status' => 200, 'title' => 'success', "result" => $result]);
    }

    public function highlights(){
        $validator = Validator::make(request()->all(), [
            'event_id' => 'required'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'title' => $validator->errors()->first()]);
        }

        extract(request()->all());
        // curr_date();

        // where('event_id',$event_id)->
        // DB::enableQueryLog();

        $highlights = Highlight::select('highlights.*')
                                ->leftJoin('matches as m','m.id','=','highlights.match_id')
                                // ->leftJoin('event_teams as et','et.id','=','matches.event_team_id_1')

                                ->leftJoin('event_teams AS et', function($join) {
                                    $join->on('et.id', '=', 'm.event_team_id_1')
                                        ->orOn('et.id', '=', 'm.event_team_id_2');
                                })

                                ->where('et.event_id',$event_id)
                                ->get()->all();

                                
        // dd(DB::getQueryLog());
        $result['highlights'] = $highlights;
        return response()->json(['status' => 200, 'title' => 'success', "result" => $result]);
    }

    public function point_table(){
        $validator = Validator::make(request()->all(), [
            'event_id' => 'required'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'title' => $validator->errors()->first()]);
        }

        extract(request()->all());
        // curr_date();

        $pointTable = EventTeam::with('team')->with('eventPointTable')->get()->all();
        $result['pointTable'] = $pointTable;
        return response()->json(['status' => 200, 'title' => 'success', "result" => $result]);
    }

    public function award_list(){
        $validator = Validator::make(request()->all(), [
            'event_id' => 'required'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'title' => $validator->errors()->first()]);
        }
        extract(request()->all());

        $awards = EventAward::where('event_id',$event_id)->get()->all();
        $result['awards'] = $awards;
        return response()->json(['status' => 200, 'title' => 'success', "result" => $result]);
    }

    public function award_list_details(){
        $validator = Validator::make(request()->all(), [
            'slug' => 'required'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'title' => $validator->errors()->first()]);
        }
        extract(request()->all());

        $awards = EventAwardHolder::select('event_award_holders.*')
                                ->leftJoin('event_awards as ea','ea.id','=','event_award_holders.event_award_id')->where('ea.slug',$slug)
                                ->with('eventTeamPlayer.player')->get()->all();
        $result['awards'] = $awards;
        return response()->json(['status' => 200, 'title' => 'success', "result" => $result]);
    }

    public function saveDeviceToken(){
        $validator = Validator::make(request()->all(), [
            'token' => 'required',
            'package_name' => 'required'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'title' => $validator->errors()->first()]);
        }

        extract(request()->all());
        
        $isApplication = Application::where('package_name',$package_name)->get()->first();
        if(!$isApplication){
            return response()->json(['status' => 310, 'title' => 'application not found with this provider name']);
        }
        
        $isDeviceToken = DeviceToken::where('application_id',$isApplication->id)->where('token',$token)->get()->first();
        if(!$isDeviceToken){
            DeviceToken::insert(
                ['token'=>$token,'application_id'=>$isApplication->id]
            );
        }
        return response()->json(['status' => 200, 'title' => 'success']);
    }

    public function removeDeviceToken(){
        $validator = Validator::make(request()->all(), [
            'token' => 'required',
            'package_name' => 'required'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'title' => $validator->errors()->first()]);
        }
        
        extract(request()->all());

        $isApplication = Application::where('package_name',$package_name)->get()->first();
        if($isApplication){
            // return response()->json(['status' => 310, 'title' => 'application not found with this provider name']);
            $isDeviceToken = DeviceToken::where('token',$token)->where('application_id',$isApplication->id)->delete();
        }

        return response()->json(['status' => 200, 'title' => 'success']);
    }

    public function appWallpapers(){
        $validator = Validator::make(request()->all(), [
            'package_name' => 'required'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'title' => $validator->errors()->first()]);
        }

        extract(request()->all());
        $result['wallpapers'] = ApplicationWallpaper::with([
            'application' => function($q) use ($package_name) {
                $q->where('package_name',$package_name);
            }
          ])->get()->all();
        return response()->json(['status' => 200, 'title' => 'success', 'result' => $result]);
    }

    public function appVideos(){
        $validator = Validator::make(request()->all(), [
            'package_name' => 'required'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'title' => $validator->errors()->first()]);
        }

        extract(request()->all());
        $result['videos'] = ApplicationVideo::with([
            'application' => function($q) use ($package_name) {
                $q->where('package_name',$package_name);
            }
          ])->get()->all();
        return response()->json(['status' => 200, 'title' => 'success', 'result' => $result]);
    }
    
}
