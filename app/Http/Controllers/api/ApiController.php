<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventWallpaper;
use App\Models\EventWinner;
use App\Models\Game;
use App\Models\Matches;
use App\Models\Stadium;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
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

        $matches = Matches::select('matches.*')->leftJoin('teams AS t1','t1.id','=','matches.team_id_1')
                            ->leftJoin('teams AS t2','t2.id','=','matches.team_id_2')
                            ->where('t1.event_id',$event_id)->whereDate('matches.match_time',curr_date())
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

        $teams = Team::where('event_id',$event_id)->get()->all();
        $result['teams'] = $teams;
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
    
}
