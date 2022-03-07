<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Player;
use App\Models\Game;
use App\Models\PlayerRole;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PlayerController extends Controller
{

    public function __construct()
    {
        $this->titles = Player::titles();
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
        $result['playerRoles'] = PlayerRole::get()->all();
        return view(backView() . '.' . $this->titles->viewNamePrefix . '_add')->with($result);
    }

    public function store(Request $request)
    {
        extract(request()->all());

        $fileName = '';
        if($request->hasFile('profile')){
            $fileName = str_replace(" ","_",time().'_'.$profile->getClientOriginalName());
            $profile->move(Player::profileLocation(),$fileName);
        }

        $player = new Player;
        $player->name = $request->name;
        $player->player_role_id = $request->role;
        $player->profile = $fileName;
        $player->save();

        $flash_s = 'Data saved successfully!';
        session()->flash('flash_s', $flash_s);
        return response()->json(['status' => 200, 'title' => $flash_s, 'result' => ['next' => url(admin() . '/' . $this->titles->viewPathPrefix)]]);
    }

    public function show(Player $player)
    {
        //
    }

    public function edit(Player $player)
    {
        $result['titles'] = $this->titles;
        $result['row'] = $player;

        
        // $result['role_selected'] = 
        $role_selected = $player->playerRole()->first();
        $game_selected = 0;
        if($role_selected){
            $game_selected = $role_selected->game()->first();
        }
        $result['game_selected'] = $game_selected;

        $result['games'] = Game::get()->all();
        $playerRoles = new PlayerRole;
        if($game_selected){
            $playerRoles = $playerRoles->where('game_id',$game_selected->id);
        }
        $playerRoles = $playerRoles->get()->all();

        $result['playerRoles'] = $playerRoles;
        return view(backView() . '.' . $this->titles->viewNamePrefix . '_edit')->with($result);
    }

    public function update(Request $request, Player $player)
    {
        extract(request()->all());

        if($request->hasFile('profile')){
            if(File::exists(Player::profileLocation().'/'.$player->profile)){
                File::delete(Player::profileLocation().'/'.$player->profile);
            }

            $fileName = str_replace(" ","_",time().'_'.$profile->getClientOriginalName());
            $profile->move(Player::profileLocation(),$fileName);
            $player->profile = $fileName;
        }

        $player->player_role_id = $request->role;
        $player->name = $request->name;
        $player->save();

        $flash_s = 'Data saved successfully!';
        session()->flash('flash_s', $flash_s);
        return response()->json(['status' => 200, 'title' => $flash_s, 'result' => ['next' => url(admin() . '/' . $this->titles->viewPathPrefix)]]);
    }

    public function destroy(Player $player)
    {
        if(File::exists(Player::profileLocation().'/'.$player->profile)){
            File::delete(Player::profileLocation().'/'.$player->profile);
        }
        $player->delete();
        $flash_s = 'Data deleted successfully!';
        return response()->json(['status' => 200, 'title' => $flash_s]);
    }

    public function validation(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required',
            'role' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'title' => 'Errors', 'result' => $validator->errors()->all()]);
        } else {
            return response()->json(['status' => 200]);
        }
    }

    public function list_data()
    {
        $data = Player::with('playerRole')->get()->all();

        return datatables($data)
            ->addColumn('action', function ($row) {
                return '<a class="btn btn-sm btn-info" href="' . $this->titles->viewPathPrefix . '/' . $row->id . '/edit/"><i class="feather icon-edit"></i> Edit</a>
                        <a oncLick="confirmDelete(' . $row->id . ',\'Player\')" class="btn btn-sm btn-danger" href="javascript:void(0);"><i class="feather icon-trash-2"></i> Delete</a>';
            })->make();
    }
}
