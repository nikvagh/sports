<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Team;
use App\Models\Game;
use App\Models\Player;
use App\Models\TeamPlayer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TeamController extends Controller
{

    public function __construct()
    {
        $this->titles = Team::titles();
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
        return view(backView() . '.' . $this->titles->viewNamePrefix . '_add')->with($result);
    }

    public function store(Request $request)
    {
        extract(request()->all());

        $fileName = '';
        if($request->hasFile('logo')){
            $fileName = str_replace(" ","_",time().'_'.$logo->getClientOriginalName());
            $logo->move(Team::logoLocation(),$fileName);
        }

        $event = Event::findOrFail($request->event);

        $team = new Team;
        $team->name = $request->name;
        $team->logo = $fileName;
        $team->points = $request->points;

        $event->teams()->save($team);

        $flash_s = 'Data saved successfully!';
        session()->flash('flash_s', $flash_s);
        return response()->json(['status' => 200, 'title' => $flash_s, 'result' => ['next' => url(admin() . '/' . $this->titles->viewPathPrefix)]]);
    }

    public function show(Team $team)
    {
        //
    }

    public function edit(Team $team)
    {
        $result['titles'] = $this->titles;
        $result['row'] = $team;
        $result['games'] = Game::get()->all();
        return view(backView() . '.' . $this->titles->viewNamePrefix . '_edit')->with($result);
    }

    public function update(Request $request, Team $team)
    {
        extract(request()->all());

        if($request->hasFile('logo')){
            if(File::exists(Team::logoLocation().'/'.$team->logo)){
                File::delete(Team::logoLocation().'/'.$team->logo);
            }

            $fileName = str_replace(" ","_",time().'_'.$logo->getClientOriginalName());
            $logo->move(Team::logoLocation(),$fileName);
            $team->logo = $fileName;
        }

        $team->event_id = $request->event;
        $team->name = $request->name;
        $team->points = $request->points;
        $team->save();

        $flash_s = 'Data saved successfully!';
        session()->flash('flash_s', $flash_s);
        return response()->json(['status' => 200, 'title' => $flash_s, 'result' => ['next' => url(admin() . '/' . $this->titles->viewPathPrefix)]]);
    }

    public function destroy(Team $team)
    {
        if(File::exists(Team::logoLocation().'/'.$team->logo)){
            File::delete(Team::logoLocation().'/'.$team->logo);
        }
        $team->delete();
        $flash_s = 'Data deleted successfully!';
        return response()->json(['status' => 200, 'title' => $flash_s]);
    }

    public function validation(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'event' => 'required',
            'name' => 'required',
            'points' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'title' => 'Errors', 'result' => $validator->errors()->all()]);
        } else {
            return response()->json(['status' => 200]);
        }
    }

    public function list_data()
    {
        $data = Team::with('event')->with('event.game')->get()->all();

        // echo "<pre>";print_r($data);
        // exit;

        return datatables($data)
            ->addColumn('action', function ($row) {
                return '<a class="btn btn-sm btn-info" href="' . $this->titles->viewPathPrefix . '/' . $row->id . '/edit/"><i class="feather icon-edit"></i> Edit</a>
                        <a oncLick="confirmDelete(' . $row->id . ',\'Team\')" class="btn btn-sm btn-danger" href="javascript:void(0);"><i class="feather icon-trash-2"></i> Delete</a>
                        <a class="btn btn-sm btn-secondary" href="' . $this->titles->viewPathPrefix . '/' . $row->id . '/editTeamPlayer/"><i class="feather icon-users"></i> Players</a>';
            })->make();
    }

    public function teamPlayerValidation(Request $request)
    {
        return response()->json(['status' => 200]);

        // $validator = Validator::make(request()->all(), [
        //     'event' => 'required',
        //     'name' => 'required',
        //     'points' => 'required'
        // ]);
        // if ($validator->fails()) {
        //     return response()->json(['status' => 400, 'title' => 'Errors', 'result' => $validator->errors()->all()]);
        // } else {
        //     return response()->json(['status' => 200]);
        // }
    }

    public function editTeamPlayer(Team $team)
    {
        $result['titles'] = $this->titles;
        $result['row'] = $team;
        $result['players'] = Player::get()->all();
        $result['teamPlayerSelected'] = $team->teamPlayers()->pluck('player_id')->toArray();
        return view(backView() . '.' . $this->titles->viewNamePrefix . '_editTeamPlayer')->with($result);
    }

    public function updateTeamPlayer(Request $request, Team $team)
    {
        extract(request()->all());

        TeamPlayer::where('team_id',$team->id)->delete();
        if(isset($players)){
            foreach($players as $key=>$val){

                $teamPlayer = new TeamPlayer;
                $teamPlayer->team_id = $team->id;
                $teamPlayer->player_id = $val;
                $teamPlayer->save();
            }
        }

        $flash_s = 'Data saved successfully!';
        session()->flash('flash_s', $flash_s);
        return response()->json(['status' => 200, 'title' => $flash_s, 'result' => ['next' => url(admin() . '/' . $this->titles->viewPathPrefix)]]);
    }
}
