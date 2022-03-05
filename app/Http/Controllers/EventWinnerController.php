<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\EventWinner;
use App\Models\Game;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class EventWinnerController extends Controller
{
    public function __construct()
    {
        $this->titles = EventWinner::titles();
    }

    public function index()
    {
        $result['titles'] = $this->titles;
        return view(backView() . '.' . $this->titles->viewNamePrefix)->with($result);
    }

    public function create()
    {
        $result['titles'] = $this->titles;
        $result['applications'] = Application::get()->all();
        $result['games'] = Game::get()->all();
        return view(backView() . '.' . $this->titles->viewNamePrefix . '_add')->with($result);
    }

    public function store(Request $request)
    {
        extract(request()->all());
        $eventWinner = new EventWinner;

        $fileName = '';
        if($request->hasFile('image')){
            $fileName = str_replace(" ","_",time().'_'.$image->getClientOriginalName());
            $image->move(EventWinner::imageLocation(),$fileName);
        }
        $eventWinner->image = $fileName;
        $eventWinner->event_id = $event;
        $eventWinner->team_id = $team;
        $eventWinner->year = $year;
        $eventWinner->save();

        $flash_s = 'Data saved successfully!';
        session()->flash('flash_s', $flash_s);
        return response()->json(['status' => 200, 'title' => $flash_s, 'result' => ['next' => url(admin() . '/' . $this->titles->viewPathPrefix)]]);
    }

    public function show(EventWinner $eventWinner)
    {
        //
    }

    public function edit(EventWinner $eventWinner)
    {
        $result['titles'] = $this->titles;
        $result['row'] = $eventWinner;
        $result['applications'] = Application::get()->all();
        return view(backView() . '.' . $this->titles->viewNamePrefix . '_edit')->with($result);
    }

    public function update(Request $request, EventWinner $eventWinner)
    {
        extract(request()->all());

        if($request->hasFile('wallpaper')){
            if(File::exists(EventWinner::imageLocation().'/'.$eventWinner->wallpaper)){
                File::delete(EventWinner::imageLocation().'/'.$eventWinner->wallpaper);
            }

            $fileName = str_replace(" ","_",time().'_'.$wallpaper->getClientOriginalName());
            $wallpaper->move(EventWinner::imageLocation(),$fileName);
            $eventWinner->wallpaper = $fileName;
        }

        $eventWinner->application_id = $request->application;
        $eventWinner->save();

        $flash_s = 'Data saved successfully!';
        session()->flash('flash_s', $flash_s);
        return response()->json(['status' => 200, 'title' => $flash_s, 'result' => ['next' => url(admin() . '/' . $this->titles->viewPathPrefix)]]);
    }

    public function destroy(EventWinner $eventWinner)
    {
        if(File::exists(EventWinner::imageLocation().'/'.$eventWinner->wallpaper)){
            File::delete(EventWinner::imageLocation().'/'.$eventWinner->wallpaper);
        }

        $eventWinner->delete();
        $flash_s = 'Data deleted successfully!';
        return response()->json(['status' => 200, 'title' => $flash_s]);
    }

    public function validation(Request $request)
    {
        $validationData = [
            'event' => 'required',
            'team' => 'required',
            'year' => 'required|date_format:Y',
        ];
        // if(request()->action == 'update'){
        //     $validationData['wallpaper'] = 'required';
        // }

        $validator = Validator::make(request()->all(), $validationData);
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'title' => 'Errors', 'result' => $validator->errors()->all()]);
        } else {
            return response()->json(['status' => 200]);
        }
    }

    public function list_data()
    {
        $data = EventWinner::with('application')->get()->all();

        return datatables($data)
            ->addColumn('action', function ($row) {
                return '<a class="btn btn-sm btn-info" href="' . $this->titles->viewPathPrefix . '/' . $row->id . '/edit/"><i class="feather icon-edit"></i> Edit</a>
                        <a oncLick="confirmDelete(' . $row->id . ',\'Wallpaper\')" class="btn btn-sm btn-danger" href="javascript:void(0);"><i class="feather icon-trash-2"></i> Delete</a>';
            })->make();
    }
}
