<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventPointTable;
use App\Models\EventTeam;
use App\Models\Game;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class EventController extends Controller
{

    public function __construct()
    {
        $this->titles = Event::titles();
    }

    public function index()
    {
        $result['titles'] = $this->titles;
        return view(backView().'.'.$this->titles->viewNamePrefix)->with($result);
    }

    public function create()
    {
        $result['titles'] = $this->titles;
        $result['games'] = Game::all();
        return view(backView().'.'.$this->titles->viewNamePrefix.'_add')->with($result);
    }

    public function store(Request $request)
    {
        $game = Game::findOrFail($request->game);

        $event = new Event;
        $event->name = $request->name;

        $game->events()->save($event);

        $flash_s = 'Data saved successfully!';
        session()->flash('flash_s',$flash_s); 
        return response()->json(['status' => 200, 'title' => $flash_s, 'result'=>['next'=>url(admin().'/'.$this->titles->viewPathPrefix)]]);
    }

    public function show(Event $event)
    {
        //
    }

    public function edit(Event $event)
    {
        $result['titles'] = $this->titles;
        $result['row'] = $event;
        $result['games'] = Game::all();
        return view(backView().'.'.$this->titles->viewNamePrefix.'_edit')->with($result);
    }

    public function update(Request $request, Event $event)
    {
        $event->game_id = $request->game;
        $event->name = $request->name;
        $event->save();
        
        $flash_s = 'Data saved successfully!';
        session()->flash('flash_s',$flash_s); 
        return response()->json(['status' => 200, 'title' => $flash_s, 'result'=>['next'=>url(admin().'/'.$this->titles->viewPathPrefix)]]);
    }

    public function destroy(Event $event)
    {
        $event = Event::findOrFail($event->id);
        $event->delete();
        $flash_s = 'Data deleted successfully!';
        return response()->json(['status' => 200, 'title' => $flash_s]);
    }

    public function validation(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'game' => 'required',
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'title' => 'Errors', 'result' => $validator->errors()->all()]);
        } else {
            return response()->json(['status' => 200]);
        }
    }

    public function list_data()
    {
        $data = Event::with('game')->get()->all();

        // echo "<pre>";print_r($data);
        // exit;
        
        return datatables($data)
            ->addColumn('action', function ($row) {
                return '<a class="btn btn-sm btn-info" href="'.$this->titles->viewPathPrefix.'/'.$row->id.'/edit/"><i class="feather icon-edit"></i> Edit</a>
                        <a oncLick="confirmDelete('.$row->id.',\'Event\')" class="btn btn-sm btn-danger" href="javascript:void(0);"><i class="feather icon-trash-2"></i> Delete</a>
                        <a class="btn btn-sm btn-dark" href="'.$this->titles->viewPathPrefix.'/'.$row->id.'/eventTeams"><i class="feather icon-users"></i> Teams</a>
                        <a class="btn btn-sm btn-warning" href="'.$this->titles->viewPathPrefix.'/'.$row->id.'/eventPointTables_edit"><i class="feather icon-bar-chart-2"></i> Points Table</a>';
            })->make();
    }

    public function eventsBYGame($game_id){
        $events = Event::where('game_id',$game_id)->get()->all();
        $result['events'] = $events;
        return response()->json(['status' => 200, 'title' => 'Success', 'result' => $result]);
    }


    public function eventPointTables_validation(Request $request)
    {
        $validator = Validator::make(request()->all(), [
                'match.*' => 'required|numeric',
                'win.*' => 'required|numeric',
                'lose.*' => 'required|numeric',
                'nrr.*' => 'required|numeric',
                'points.*' => 'required|numeric',
            ],
            [
                'match.*.required' => 'All matches fields are required',
                'win.*.required' => 'All win fields are required',
                'lose.*.required' => 'All lose fields are required',
                'nrr.*.required' => 'All nrr fields are required',
                'points.*.required' => 'All points fields are required',

                'match.*.numeric' => 'All matches fields must be a number.',
                'win.*.numeric' => 'All win must be a number.',
                'lose.*.numeric' => 'All lose must be a number.',
                'nrr.*.numeric' => 'All nrr must be a number.',
                'points.*.numeric' => 'All points must be a number.'
            ]
        );
        
        if ($validator->fails()) {
            
            $newMessages = [];
            foreach($validator->errors()->all() as $val){
                if(!in_array($val,$newMessages)){
                    $newMessages[] = $val;
                }
            }

            return response()->json(['status' => 400, 'title' => 'Errors', 'result' => $newMessages]);
        } else {
            return response()->json(['status' => 200]);
        }
    }

    public function eventPointTables_edit(Request $request){
        $result['titles'] = $this->titles;
        $result['event_id'] = $event_id = $request->event_id;
        
        $result['teams'] = EventTeam::where('event_id',$event_id)->with('team')->with('eventPointTable')->get()->all();

        // echo "<pre>";
        // print_r($result);
        // exit;
        return view(backView().'.'.$this->titles->viewNamePrefix.'PointTables_edit')->with($result);
    }

    public function eventPointTables_update(Request $request)
    {
        // echo "<pre>";
        // print_r($request->all());
        // exit;
        if($request['match']){
            foreach($request['match'] as $key=>$val){

                $isEventPointTable = EventPointTable::where('event_team_id',$key)->get()->first();
                if($isEventPointTable){
                    $eventPointTable = $isEventPointTable;
                }else{
                    $eventPointTable = new EventPointTable;
                    $eventPointTable->event_team_id = $key;
                }
                $eventPointTable->match = $request['match'][$key];
                $eventPointTable->win = $request['win'][$key];
                $eventPointTable->lose = $request['lose'][$key];
                $eventPointTable->nrr = $request['nrr'][$key];
                $eventPointTable->points = $request['points'][$key];
                $eventPointTable->save();

            }
        }
        
        $flash_s = 'Data saved successfully!';
        session()->flash('flash_s',$flash_s); 
        return response()->json(['status' => 200, 'title' => $flash_s, 'result'=>['next'=>url(admin().'/'.$this->titles->viewPathPrefix)]]);
    }
}
