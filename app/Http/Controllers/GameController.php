<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class GameController extends Controller
{

    public function __construct()
    {
        $this->titles = Game::titles();
    }

    public function index()
    {
        $result['titles'] = $this->titles;
        return view(backView().'.'.$this->titles->viewNamePrefix)->with($result);
    }

    public function create()
    {
        $result['titles'] = $this->titles;
        return view(backView().'.'.$this->titles->viewNamePrefix.'_add')->with($result);
    }

    public function store(Request $request)
    {
        $user = new Game;
        $user->name = $request->name;
        $user->save();

        $flash_s = 'Data saved successfully!';
        session()->flash('flash_s',$flash_s); 
        return response()->json(['status' => 200, 'title' => $flash_s, 'result'=>['next'=>url(admin().'/'.$this->titles->viewPathPrefix)]]);
    }

    public function show(Game $game)
    {
        //
    }

    public function edit(Game $game)
    {
        $result['titles'] = $this->titles;
        $result['row'] = $game;
        return view(backView().'.'.$this->titles->viewNamePrefix.'_edit')->with($result);
    }

    public function update(Request $request, Game $game)
    {
        $game->name = $request->name;
        $game->save();

        $flash_s = 'Data saved successfully!';
        session()->flash('flash_s',$flash_s); 
        return response()->json(['status' => 200, 'title' => $flash_s, 'result'=>['next'=>url(admin().'/'.$this->titles->viewPathPrefix)]]);
    }

    public function destroy(Game $game)
    {
        $game = Game::findOrFail($game->id);
        $game->delete();
        $flash_s = 'Data deleted successfully!';
        return response()->json(['status' => 200, 'title' => $flash_s]);
    }

    public function validation(Request $request)
    {   
        $validator = Validator::make(request()->all(), [
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
        $data = Game::get()->all();

        // echo "<pre>";print_r($data);
        // exit;
        
        return datatables($data)
            ->addColumn('action', function ($row) {
                return '<a class="btn btn-sm btn-info" href="'.$this->titles->viewPathPrefix.'/'.$row->id.'/edit/"><i class="feather icon-edit"></i> Edit</a>
                        <a oncLick="confirmDelete('.$row->id.',\'Game\')" class="btn btn-sm btn-danger" href="javascript:void(0);"><i class="feather icon-trash-2"></i> Delete</a>';
            })->make();
    }

}
