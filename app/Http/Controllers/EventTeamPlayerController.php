<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventTeam;
use App\Models\EventTeamPlayer;
use App\Models\Game;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class EventTeamPlayerController extends Controller
{

    public function __construct(Request $request)
    {
        $this->titles = EventTeamPlayer::titles($request->event_id,$request->event_team_id);
    }

    public function index(Request $request)
    {
        $result['titles'] = $this->titles;
        // $result['event'] = Event::find($request->event_id);
        $result['event_id'] = $request->event_id;
        $result['event_team_id'] = $request->event_team_id;
        return view(backView().'.'.$this->titles->viewNamePrefix)->with($result);
    }

    public function create(Request $request)
    {
        $result['titles'] = $this->titles;
        // $result['games'] = Game::all();
        $result['players'] = Player::get()->all();
        $result['event_id'] = $request->event_id;
        $result['event_team_id'] = $request->event_team_id;
        return view(backView().'.'.$this->titles->viewNamePrefix.'_add')->with($result);
    }

    public function store(Request $request)
    {
        // $game = Game::findOrFail($request->game);

        $eventTeamPlayer = new EventTeamPlayer;
        $eventTeamPlayer->event_team_id = $request->event_team_id;
        $eventTeamPlayer->player_id = $request->player;
        $eventTeamPlayer->price = $request->price;
        $eventTeamPlayer->save();

        $flash_s = 'Data saved successfully!';
        session()->flash('flash_s',$flash_s); 
        return response()->json(['status' => 200, 'title' => $flash_s, 'result'=>['next'=>url(admin().'/events/'.$request->event_id.'/eventTeams/'.$request->event_team_id.'/'.$this->titles->viewPathPrefix)]]);
    }

    public function show(EventTeam $eventTeam)
    {
        //
    }

    public function edit($event_id,$event_team_id,EventTeamPlayer $eventTeamPlayer)
    {
        $result['titles'] = $this->titles;
        $result['players'] = Player::get()->all();
        $result['event_id'] = request()->event_id;
        $result['event_team_id'] = request()->event_team_id;
        $result['row'] = $eventTeamPlayer;
        return view(backView().'.'.$this->titles->viewNamePrefix.'_edit')->with($result);
    }

    public function update(Request $request,$event_id, $event_team_id,EventTeamPlayer $eventTeamPlayer)
    {
        $eventTeamPlayer->player_id = $request->player;
        $eventTeamPlayer->price = $request->price;
        $eventTeamPlayer->save();
        
        $flash_s = 'Data saved successfully!';
        session()->flash('flash_s',$flash_s); 
        return response()->json(['status' => 200, 'title' => $flash_s, 'result'=>['next'=>url(admin().'/events/'.$request->event_id.'/eventTeams/'.$request->event_team_id.'/'.$this->titles->viewPathPrefix)]]);
    }

    public function destroy($event_id,$event_team_id,EventTeamPlayer $eventTeamPlayer)
    {
        $event = EventTeamPlayer::findOrFail($eventTeamPlayer->id);
        $event->delete();
        $flash_s = 'Data deleted successfully!';
        return response()->json(['status' => 200, 'title' => $flash_s]);
    }

    public function validation(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'player' => 'required',
            'price' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'title' => 'Errors', 'result' => $validator->errors()->all()]);
        } else {
            return response()->json(['status' => 200]);
        }
    }

    public function list_data(Request $request)
    {
        $data = EventTeamPlayer::where('event_team_id',$request->event_team_id)->with('player')->with('eventTeam')->with('eventTeam.team')->get()->all();

        // echo "<pre>";print_r($data);
        // exit;
        
        return datatables($data)
            ->addColumn('action', function ($row) {
                return '<a class="btn btn-sm btn-info" href="'.$this->titles->viewPathPrefix.'/'.$row->id.'/edit/"><i class="feather icon-edit"></i> Edit</a>
                        <a oncLick="confirmDelete(\''.$row->eventTeam->event_id.'_'.$row->event_team_id.'_'.$row->id.'\',\'EventTeam\')" class="btn btn-sm btn-danger" href="javascript:void(0);"><i class="feather icon-trash-2"></i> Delete</a>';
            })->make();
    }

    public function eventTeamPlayersByEvent($event_id){
        $eventTeamPlayers = EventTeamPlayer::select('event_team_players.*')
                                            ->leftJoin('event_teams as et','et.id','=','event_team_players.event_team_id')
                                            ->where('et.event_id',$event_id)
                                            ->with('player')->get()->all();
        $result['eventTeamPlayers'] = $eventTeamPlayers;
        return response()->json(['status' => 200, 'title' => 'Success', 'result' => $result]);
    }

}
