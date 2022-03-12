<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventTeam;
use App\Models\Game;
use App\Models\Team;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class EventTeamController extends Controller
{

    public function __construct(Request $request)
    {
        $this->titles = EventTeam::titles($request->event_id);
    }

    public function index(Request $request)
    {
        $result['titles'] = $this->titles;
        // $result['event'] = Event::find($request->event_id);
        $result['event_id'] = $request->event_id;
        return view(backView().'.'.$this->titles->viewNamePrefix)->with($result);
    }

    public function create(Request $request)
    {
        $result['titles'] = $this->titles;
        // $result['games'] = Game::all();
        // $result['events'] = Game::all();
        $result['teams'] = Team::get()->all();
        $result['event_id'] = $request->event_id;
        return view(backView().'.'.$this->titles->viewNamePrefix.'_add')->with($result);
    }

    public function store(Request $request)
    {
        // $game = Game::findOrFail($request->game);

        $eventTeam = new EventTeam;
        $eventTeam->team_id = $request->team;
        $eventTeam->event_id = $request->event_id;
        $eventTeam->coach = $request->coach;
        $eventTeam->owner = $request->owner;
        $eventTeam->caption = $request->owner;

        $eventTeam->save();

        $flash_s = 'Data saved successfully!';
        session()->flash('flash_s',$flash_s); 
        return response()->json(['status' => 200, 'title' => $flash_s, 'result'=>['next'=>url(admin().'/events/'.$request->event_id.'/'.$this->titles->viewPathPrefix)]]);
    }

    public function show(EventTeam $eventTeam)
    {
        //
    }

    public function edit($event_id,EventTeam $eventTeam)
    {
        $result['titles'] = $this->titles;
        $result['teams'] = Team::get()->all();
        $result['event_id'] = request()->event_id;
        $result['row'] = $eventTeam;

        return view(backView().'.'.$this->titles->viewNamePrefix.'_edit')->with($result);
    }

    public function update(Request $request,$event_id, EventTeam $eventTeam)
    {
        $eventTeam->team_id = $request->team;
        $eventTeam->coach = $request->coach;
        $eventTeam->owner = $request->owner;
        $eventTeam->caption = $request->owner;
        $eventTeam->save();
        
        $flash_s = 'Data saved successfully!';
        session()->flash('flash_s',$flash_s); 
        return response()->json(['status' => 200, 'title' => $flash_s, 'result'=>['next'=>url(admin().'/events/'.$request->event_id.'/'.$this->titles->viewPathPrefix)]]);
    }

    public function destroy($event_id,EventTeam $eventTeam)
    {
        $event = EventTeam::findOrFail($eventTeam->id);
        $event->delete();
        $flash_s = 'Data deleted successfully!';
        return response()->json(['status' => 200, 'title' => $flash_s]);
    }

    public function validation(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            // 'game' => 'required',
            // 'event' => 'required',
            'team' => 'required',
            'coach' => 'required',
            'owner' => 'required',
            'caption' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'title' => 'Errors', 'result' => $validator->errors()->all()]);
        } else {
            return response()->json(['status' => 200]);
        }
    }

    public function list_data(Request $request)
    {
        //  echo "<pre>";print_r($request);
        // exit;

        $data = EventTeam::with('team')->where('event_id',$request->event_id)->get()->all();

        return datatables($data)
            ->addColumn('action', function ($row) {
                return '<a class="btn btn-sm btn-info" href="'.$this->titles->viewPathPrefix.'/'.$row->id.'/edit/"><i class="feather icon-edit"></i> Edit</a>
                        <a oncLick="confirmDelete(\''.$row->event_id.'_'.$row->id.'\',\'EventTeam\')" class="btn btn-sm btn-danger" href="javascript:void(0);"><i class="feather icon-trash-2"></i> Delete</a>
                        <a class="btn btn-sm btn-warning" href="'.$this->titles->viewPathPrefix.'/'.$row->id.'/eventTeamPlayers"><i class="feather icon-users"></i> Players</a>';
            })->make();
    }

}
