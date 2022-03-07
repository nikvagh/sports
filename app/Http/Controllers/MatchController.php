<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventTeam;
use App\Models\Game;
use App\Models\Highlight;
use App\Models\Matches;
use App\Models\Stadium;
use App\Models\Team;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MatchController extends Controller
{

    public function __construct()
    {
        $this->titles = Matches::titles();
    }

    public function index()
    {
        $result['titles'] = $this->titles;
        return view(backView() . '.' . $this->titles->viewNamePrefix)->with($result);
    }

    public function create()
    {
        $result['titles'] = $this->titles;
        // $result['games'] = Game::get()->all();
        $result['games'] = Game::with('events')->get()->all();
        // $result['gamesForStadium'] = Game::with('events')->has('events.stadiums')->get()->all();
        return view(backView() . '.' . $this->titles->viewNamePrefix . '_add')->with($result);
    }

    public function store(Request $request)
    {
        extract(request()->all());

        $match = new Matches;
        $match->event_team_id_1 = $team_1;
        $match->event_team_id_2 = $team_2;
        $match->stadium_id = $stadium;
        $match->match_time = $match_time;

        $match->save();

        $flash_s = 'Data saved successfully!';
        session()->flash('flash_s', $flash_s);
        return response()->json(['status' => 200, 'title' => $flash_s, 'result' => ['next' => url(admin() . '/' . $this->titles->viewPathPrefix)]]);
    }

    public function show(Matches $match)
    {
        //
    }

    public function edit(Matches $match)
    {
        $result['titles'] = $this->titles;
        $result['row'] = $match;

        $result['stadium_selected'] = $stadium_selected = $match->stadium()->first();
        $result['event_selected'] = $event_selected = $stadium_selected->event()->first();
        $result['game_selected'] = $game_selected = $event_selected->game()->first();
        $result['team1_selected'] = $match->team1()->with('team')->first();
        $result['team2_selected'] = $match->team2()->with('team')->first();

        $result['games'] = Game::get()->all();
        $result['events'] = Event::where('game_id',$game_selected->id)->get();
        $result['teams'] = EventTeam::where('event_id',$event_selected->id)->with('team')->get();
        $result['stadiums'] = Stadium::where('event_id',$event_selected->id)->get();
        return view(backView() . '.' . $this->titles->viewNamePrefix . '_edit')->with($result);
    }

    public function update(Request $request, Matches $match)
    {
        extract(request()->all());

        $match->event_team_id_1 = $team_1;
        $match->event_team_id_2 = $team_2;
        $match->stadium_id = $stadium;
        $match->match_time = $match_time;

        $match->save();

        $flash_s = 'Data saved successfully!';
        session()->flash('flash_s', $flash_s);
        return response()->json(['status' => 200, 'title' => $flash_s, 'result' => ['next' => url(admin() . '/' . $this->titles->viewPathPrefix)]]);
    }

    public function destroy(Matches $match)
    {
        // $isHighlight = $match->highlight()->get()->first();
        // if($isHighlight){
        //     if(File::exists(Highlight::videoLocation().'/'.$isHighlight->video)){
        //         File::delete(Highlight::videoLocation().'/'.$isHighlight->video);
        //     }
        // }

        $match->delete();
        $flash_s = 'Data deleted successfully!';
        return response()->json(['status' => 200, 'title' => $flash_s]);
    }

    public function validation(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'team_1' => 'required',
            'team_2' => 'required',
            'stadium' => 'required',
            'match_time' => 'required|date_format:Y-m-d H:i',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'title' => 'Errors', 'result' => $validator->errors()->all()]);
        }

        extract(request()->all());

        if($team_1 == $team_2){
            return response()->json(['status' => 320, 'title' => 'Errors', 'result' => ['Team 1, team 2 must be different']]);
        }

        return response()->json(['status' => 200]);
    }

    public function list_data()
    {
        $data = Matches::with('team1')->with('team1.team')->with('team2')->with('team2.team')->with('stadium')->get()->all();

        return datatables($data)
            ->addColumn('action', function ($row) {
                return '<a class="btn btn-sm btn-info" href="' . $this->titles->viewPathPrefix . '/' . $row->id . '/edit/"><i class="feather icon-edit"></i> Edit</a>
                        <a oncLick="confirmDelete(' . $row->id . ',\'Match\')" class="btn btn-sm btn-danger" href="javascript:void(0);"><i class="feather icon-trash-2"></i> Delete</a>
                        <a class="btn btn-sm btn-warning" href="' . $this->titles->viewPathPrefix . '/' . $row->id . '/editHighlight/"><i class="feather icon-airplay"></i> Highlight</a>
                        ';
            })->make();
    }


    public function validationHighlight(Request $request)
    {
        // return response()->json(['status' => 200]);

        $validator = Validator::make(request()->all(), [
            'video' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'title' => 'Errors', 'result' => $validator->errors()->all()]);
        } else {
            return response()->json(['status' => 200]);
        }
    }

    public function editHighlight(Matches $match)
    {
        $result['titles'] = $this->titles;
        $result['row'] = $match->where('id',$match->id)->with('team1')->with('team2')->get()->first();

        $result['highlight'] = $match->highlight()->get()->first();

        // echo "<pre>";
        // print_r($result['row']);
        // exit;
        return view(backView() . '.' . $this->titles->viewNamePrefix . '_editHighlight')->with($result);
    }

    public function updateHighlight(Request $request, Matches $match)
    {
        extract(request()->all());

        if($request->hasFile('video')){
            $isHighlight = Highlight::where('match_id',$match->id)->get()->first();
            if($isHighlight){
                if(File::exists(Highlight::videoLocation().'/'.$isHighlight->video)){
                    File::delete(Highlight::videoLocation().'/'.$isHighlight->video);
                }
            }

            $fileName = str_replace(" ","_",time().'_'.$video->getClientOriginalName());
            $video->move(Highlight::videoLocation(),$fileName);

            
            if($isHighlight){
                $isHighlight->video = $fileName;
                $isHighlight->save();
            }else{
                $highlight = new highlight;
                $highlight->video = $fileName;
                $highlight->match_id = $match->id;
                $highlight->save();
            }
        }

        $flash_s = 'Data saved successfully!';
        session()->flash('flash_s', $flash_s);
        return response()->json(['status' => 200, 'title' => $flash_s, 'result' => ['next' => url(admin() . '/' . $this->titles->viewPathPrefix)]]);
    }
}
