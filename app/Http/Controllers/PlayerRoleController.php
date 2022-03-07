<?php

namespace App\Http\Controllers;

use App\Models\PlayerRole;
use App\Models\Game;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class PlayerRoleController extends Controller
{

    public function __construct()
    {
        $this->titles = PlayerRole::titles();
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

        $playerRole = new PlayerRole;
        $playerRole->name = $request->name;

        $game->playerRoles()->save($playerRole);

        $flash_s = 'Data saved successfully!';
        session()->flash('flash_s',$flash_s); 
        return response()->json(['status' => 200, 'title' => $flash_s, 'result'=>['next'=>url(admin().'/'.$this->titles->viewPathPrefix)]]);
    }

    public function show(PlayerRole $playerRole)
    {
        //
    }

    public function edit(PlayerRole $playerRole)
    {
        $result['titles'] = $this->titles;
        $result['row'] = $playerRole;
        $result['games'] = Game::all();
        return view(backView().'.'.$this->titles->viewNamePrefix.'_edit')->with($result);
    }

    public function update(Request $request, PlayerRole $playerRole)
    {
        $playerRole->game_id = $request->game;
        $playerRole->name = $request->name;
        $playerRole->save();
        
        $flash_s = 'Data saved successfully!';
        session()->flash('flash_s',$flash_s); 
        return response()->json(['status' => 200, 'title' => $flash_s, 'result'=>['next'=>url(admin().'/'.$this->titles->viewPathPrefix)]]);
    }

    public function destroy(PlayerRole $playerRole)
    {
        $playerRole = PlayerRole::findOrFail($playerRole->id);
        $playerRole->delete();
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
        $data = PlayerRole::with('game')->get()->all();

        // echo "<pre>";print_r($data);
        // exit;
        
        return datatables($data)
            ->addColumn('action', function ($row) {
                return '<a class="btn btn-sm btn-info" href="'.$this->titles->viewPathPrefix.'/'.$row->id.'/edit/"><i class="feather icon-edit"></i> Edit</a>
                        <a oncLick="confirmDelete('.$row->id.',\'PlayerRole\')" class="btn btn-sm btn-danger" href="javascript:void(0);"><i class="feather icon-trash-2"></i> Delete</a>';
            })->make();
    }

    public function roleByGame($game_id){
        $playerRoles = PlayerRole::where('game_id',$game_id)->get()->all();
        $result['playerRoles'] = $playerRoles;
        return response()->json(['status' => 200, 'title' => 'Success', 'result' => $result]);
    }

}
