<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventAward;
use App\Models\Game;
use App\Models\Player;
use App\Models\Team;
use App\Models\TeamPlayer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class EventAwardController extends Controller
{
    public function __construct()
    {
        $this->titles = EventAward::titles();
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
        return view(backView() . '.' . $this->titles->viewNamePrefix . '_add')->with($result);
    }

    public function store(Request $request)
    {
        extract(request()->all());

        $eventAward = new EventAward;
        $eventAward->title = $title;
        $eventAward->slug = trim($slug);
        $eventAward->save();

        $flash_s = 'Data saved successfully!';
        session()->flash('flash_s', $flash_s);
        return response()->json(['status' => 200, 'title' => $flash_s, 'result' => ['next' => url(admin() . '/' . $this->titles->viewPathPrefix)]]);
    }

    public function show(EventAward $eventAward)
    {
        //
    }

    public function edit(EventAward $eventAward)
    {
        $result['titles'] = $this->titles;
        $result['row'] = $eventAward;
        // $result['games'] = Game::get()->all();
        return view(backView() . '.' . $this->titles->viewNamePrefix . '_edit')->with($result);
    }

    public function update(Request $request, EventAward $eventAward)
    {
        extract(request()->all());
        $eventAward->title = $title;
        // $eventAward->slug = trim($slug);
        $eventAward->save();

        $flash_s = 'Data saved successfully!';
        session()->flash('flash_s', $flash_s);
        return response()->json(['status' => 200, 'title' => $flash_s, 'result' => ['next' => url(admin() . '/' . $this->titles->viewPathPrefix)]]);
    }

    public function destroy(EventAward $eventAward)
    {
        $eventAward->delete();
        $flash_s = 'Data deleted successfully!';
        return response()->json(['status' => 200, 'title' => $flash_s]);
    }

    public function validation(Request $request)
    {
        Validator::extend('without_spaces', function($attr, $value){
            return preg_match('/^\S*$/u', $value);
        });
        
        $validator = Validator::make(request()->all(), [
            'title' => 'required',
            'slug' => 'required|without_spaces'
        ],[
            'slug.without_spaces' => 'The spaces not allow for :attributes field.'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'title' => 'Errors', 'result' => $validator->errors()->all()]);
        } else {
            return response()->json(['status' => 200]);
        }
    }

    public function list_data()
    {
        $data = EventAward::get()->all();

        return datatables($data)
            ->addColumn('action', function ($row) {
                return '<a class="btn btn-sm btn-info" href="' . $this->titles->viewPathPrefix . '/' . $row->id . '/edit/"><i class="feather icon-edit"></i> Edit</a>
                        <a oncLick="confirmDelete(' . $row->id . ',\'Award\')" class="btn btn-sm btn-danger" href="javascript:void(0);"><i class="feather icon-trash-2"></i> Delete</a>';
            })->make();
    }
}
