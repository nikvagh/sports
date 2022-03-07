<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventAward;
use App\Models\EventAwardHolder;
use App\Models\EventTeamPlayer;
use App\Models\Game;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class EventAwardHolderController extends Controller
{
    public function __construct()
    {
        $this->titles = EventAwardHolder::titles();
    }

    public function index()
    {
        $result['titles'] = $this->titles;
        return view(backView() . '.' . $this->titles->viewNamePrefix)->with($result);
    }

    public function create()
    {
        $result['titles'] = $this->titles;
        $result['games'] = Game::get()->all();
        $result['eventAwards'] = EventAward::get()->all();
        return view(backView() . '.' . $this->titles->viewNamePrefix . '_add')->with($result);
    }

    public function store(Request $request)
    {
        extract(request()->all());

        $eventAwardHolder = new EventAwardHolder;
        $eventAwardHolder->event_award_id = $request->award;
        $eventAwardHolder->event_team_player_id = $request->player;
        $eventAwardHolder->total = $request->total;
        $eventAwardHolder->save();

        $flash_s = 'Data saved successfully!';
        session()->flash('flash_s', $flash_s);
        return response()->json(['status' => 200, 'title' => $flash_s, 'result' => ['next' => url(admin() . '/' . $this->titles->viewPathPrefix)]]);
    }

    public function show(EventAwardHolder $eventAwardHolder)
    {
        //
    }

    public function edit(EventAwardHolder $eventAwardHolder)
    {
        $result['titles'] = $this->titles;
        $result['row'] = $eventAwardHolder;

        // $result['award_selected'] = 
        $award_selected = $eventAwardHolder->eventAward()->first();
        $result['event_selected'] = $event_selected = $award_selected->event()->first();
        $result['game_selected'] = $game_selected = $event_selected->game()->first();
        
        $result['games'] = Game::get()->all();
        $result['events'] = Event::where('game_id',$game_selected->id)->get()->all();
        $result['awards'] = EventAward::where('event_id',$event_selected->id)->get()->all();
        $result['players'] = EventTeamPlayer::select('event_team_players.*')->leftJoin('event_teams as et','et.id','=','event_team_players.event_team_id')
                                            ->where('et.event_id',$event_selected->id)->with('player')->get()->all();
        return view(backView() . '.' . $this->titles->viewNamePrefix . '_edit')->with($result);
    }

    public function update(Request $request, EventAwardHolder $eventAwardHolder)
    {
        extract(request()->all());
        $eventAwardHolder->event_award_id = $request->award;
        $eventAwardHolder->event_team_player_id = $request->player;
        $eventAwardHolder->total = $request->total;
        $eventAwardHolder->save();

        $flash_s = 'Data saved successfully!';
        session()->flash('flash_s', $flash_s);
        return response()->json(['status' => 200, 'title' => $flash_s, 'result' => ['next' => url(admin() . '/' . $this->titles->viewPathPrefix)]]);
    }

    public function destroy(EventAwardHolder $eventAwardHolder)
    {
        $eventAwardHolder->delete();
        $flash_s = 'Data deleted successfully!';
        return response()->json(['status' => 200, 'title' => $flash_s]);
    }

    public function validation(Request $request)
    {
        
        $validator = Validator::make(request()->all(), [
            'award' => 'required',
            'player' => 'required',
            'total' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'title' => 'Errors', 'result' => $validator->errors()->all()]);
        } else {
            return response()->json(['status' => 200]);
        }
    }

    public function list_data()
    {
        $data = EventAwardHolder::with('eventAward')->with('eventAward.event')->with('eventTeamPlayer.player')->get()->all();

        return datatables($data)
            ->addColumn('action', function ($row) {
                return '<a class="btn btn-sm btn-info" href="' . $this->titles->viewPathPrefix . '/' . $row->id . '/edit/"><i class="feather icon-edit"></i> Edit</a>
                        <a oncLick="confirmDelete(' . $row->id . ',\'Award\')" class="btn btn-sm btn-danger" href="javascript:void(0);"><i class="feather icon-trash-2"></i> Delete</a>';
            })->make();
    }
}
