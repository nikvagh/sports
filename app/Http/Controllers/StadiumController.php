<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Stadium;
use App\Models\Game;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class StadiumController extends Controller
{

    public function __construct()
    {
        $this->titles = Stadium::titles();
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
        if($request->hasFile('image')){
            $fileName = str_replace(" ","_",time().'_'.$image->getClientOriginalName());
            $image->move(Stadium::imageLocation(),$fileName);
        }

        $event = Event::find($request->event);

        $stadium = new Stadium;
        $stadium->name = $request->name;
        $stadium->image = $fileName;

        $event->stadiums()->save($stadium);

        $flash_s = 'Data saved successfully!';
        session()->flash('flash_s', $flash_s);
        return response()->json(['status' => 200, 'title' => $flash_s, 'result' => ['next' => url(admin() . '/' . $this->titles->viewPathPrefix)]]);
    }

    public function show(Stadium $stadium)
    {
        //
    }

    public function edit(Stadium $stadium)
    {
        $result['titles'] = $this->titles;
        $result['row'] = $stadium;
        $result['games'] = Game::get()->all();
        return view(backView() . '.' . $this->titles->viewNamePrefix . '_edit')->with($result);
    }

    public function update(Request $request, Stadium $stadium)
    {
        extract(request()->all());

        if($request->hasFile('image')){
            if(File::exists(Stadium::imageLocation().'/'.$stadium->image)){
                File::delete(Stadium::imageLocation().'/'.$stadium->image);
            }

            $fileName = str_replace(" ","_",time().'_'.$image->getClientOriginalName());
            $image->move(Stadium::imageLocation(),$fileName);
            $stadium->image = $fileName;
        }

        $stadium->event_id = $request->event;
        $stadium->name = $request->name;
        $stadium->save();

        $flash_s = 'Data saved successfully!';
        session()->flash('flash_s', $flash_s);
        return response()->json(['status' => 200, 'title' => $flash_s, 'result' => ['next' => url(admin() . '/' . $this->titles->viewPathPrefix)]]);
    }

    public function destroy(Stadium $stadium)
    {
        if(File::exists(Stadium::imageLocation().'/'.$stadium->image)){
            File::delete(Stadium::imageLocation().'/'.$stadium->image);
        }
        $stadium->delete();
        $flash_s = 'Data deleted successfully!';
        return response()->json(['status' => 200, 'title' => $flash_s]);
    }

    public function validation(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'event' => 'required',
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
        $data = Stadium::get()->all();

        return datatables($data)
            ->addColumn('action', function ($row) {
                return '<a class="btn btn-sm btn-info" href="' . $this->titles->viewPathPrefix . '/' . $row->id . '/edit/"><i class="feather icon-edit"></i> Edit</a>
                        <a oncLick="confirmDelete(' . $row->id . ',\'Stadium\')" class="btn btn-sm btn-danger" href="javascript:void(0);"><i class="feather icon-trash-2"></i> Delete</a>';
            })->make();
    }
}
