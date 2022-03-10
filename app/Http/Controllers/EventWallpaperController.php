<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventWallpaper;
use App\Models\Game;
use App\Models\Player;
use App\Models\Team;
use App\Models\TeamPlayer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class eventWallpaperController extends Controller
{
    public function __construct()
    {
        $this->titles = EventWallpaper::titles();
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
        $eventWallpaper = new EventWallpaper;

        $fileName = '';
        if($request->hasFile('wallpaper')){
            $fileName = str_replace(" ","_",time().'_'.$wallpaper->getClientOriginalName());
            $wallpaper->move(EventWallpaper::wallpaperLocation(),$fileName);
        }
        $eventWallpaper->wallpaper = $fileName;
        $eventWallpaper->event_id = $event;

        $eventWallpaper->save();

        $flash_s = 'Data saved successfully!';
        session()->flash('flash_s', $flash_s);
        return response()->json(['status' => 200, 'title' => $flash_s, 'result' => ['next' => url(admin() . '/' . $this->titles->viewPathPrefix)]]);
    }

    public function show(EventWallpaper $eventWallpaper)
    {
        //
    }

    public function edit(EventWallpaper $eventWallpaper)
    {
        $result['titles'] = $this->titles;
        $result['row'] = $eventWallpaper;

        $result['game_selected'] = $game_selected = $eventWallpaper->event()->first()->game()->first();
        
        $result['games'] = Game::get()->all();
        $result['events'] = Event::where('game_id',$game_selected->id)->get()->all();
        $result['games'] = Game::get()->all();

        return view(backView() . '.' . $this->titles->viewNamePrefix . '_edit')->with($result);
    }

    public function update(Request $request, EventWallpaper $eventWallpaper)
    {
        extract(request()->all());

        if($request->hasFile('wallpaper')){
            if(File::exists(EventWallpaper::wallpaperLocation().'/'.$eventWallpaper->wallpaper)){
                File::delete(EventWallpaper::wallpaperLocation().'/'.$eventWallpaper->wallpaper);
            }

            $fileName = str_replace(" ","_",time().'_'.$wallpaper->getClientOriginalName());
            $wallpaper->move(EventWallpaper::wallpaperLocation(),$fileName);
            $eventWallpaper->wallpaper = $fileName;
        }

        $eventWallpaper->event_id = $request->event;
        $eventWallpaper->save();

        $flash_s = 'Data saved successfully!';
        session()->flash('flash_s', $flash_s);
        return response()->json(['status' => 200, 'title' => $flash_s, 'result' => ['next' => url(admin() . '/' . $this->titles->viewPathPrefix)]]);
    }

    public function destroy(EventWallpaper $eventWallpaper)
    {
        if(File::exists(EventWallpaper::wallpaperLocation().'/'.$eventWallpaper->wallpaper)){
            File::delete(EventWallpaper::wallpaperLocation().'/'.$eventWallpaper->wallpaper);
        }

        $eventWallpaper->delete();
        $flash_s = 'Data deleted successfully!';
        return response()->json(['status' => 200, 'title' => $flash_s]);
    }

    public function validation(Request $request)
    {
        $validationData = [
            'event' => 'required',
        ];
        if(request()->action == 'create'){
            $validationData['wallpaper'] = 'required';
        }

        $validator = Validator::make(request()->all(), $validationData);
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'title' => 'Errors', 'result' => $validator->errors()->all()]);
        } else {
            return response()->json(['status' => 200]);
        }
    }

    public function list_data()
    {
        $data = EventWallpaper::with('event')->get()->all();

        return datatables($data)
            ->addColumn('action', function ($row) {
                return '<a class="btn btn-sm btn-info" href="' . $this->titles->viewPathPrefix . '/' . $row->id . '/edit/"><i class="feather icon-edit"></i> Edit</a>
                        <a oncLick="confirmDelete(' . $row->id . ',\'Wallpaper\')" class="btn btn-sm btn-danger" href="javascript:void(0);"><i class="feather icon-trash-2"></i> Delete</a>';
            })->make();
    }
}
