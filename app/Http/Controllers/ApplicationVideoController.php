<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ApplicationVideo;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ApplicationVideoController extends Controller
{
    public function __construct()
    {
        $this->titles = ApplicationVideo::titles();
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
        return view(backView() . '.' . $this->titles->viewNamePrefix . '_add')->with($result);
    }

    public function store(Request $request)
    {
        extract(request()->all());
        $applicationVideo = new ApplicationVideo;

        $fileName = '';
        if($request->hasFile('video')){
            $fileName = str_replace(" ","_",time().'_'.$video->getClientOriginalName());
            $video->move(ApplicationVideo::videoLocation(),$fileName);
        }
        $applicationVideo->video = $fileName;
        $applicationVideo->application_id = $application;

        $applicationVideo->save();

        $flash_s = 'Data saved successfully!';
        session()->flash('flash_s', $flash_s);
        return response()->json(['status' => 200, 'title' => $flash_s, 'result' => ['next' => url(admin() . '/' . $this->titles->viewPathPrefix)]]);
    }

    public function show(ApplicationVideo $applicationVideo)
    {
        //
    }

    public function edit(ApplicationVideo $applicationVideo)
    {
        $result['titles'] = $this->titles;
        $result['row'] = $applicationVideo;
        $result['applications'] = Application::get()->all();
        return view(backView() . '.' . $this->titles->viewNamePrefix . '_edit')->with($result);
    }

    public function update(Request $request, ApplicationVideo $applicationVideo)
    {
        extract(request()->all());

        if($request->hasFile('video')){
            if(File::exists(ApplicationVideo::videoLocation().'/'.$applicationVideo->video)){
                File::delete(ApplicationVideo::videoLocation().'/'.$applicationVideo->video);
            }

            $fileName = str_replace(" ","_",time().'_'.$video->getClientOriginalName());
            $video->move(ApplicationVideo::videoLocation(),$fileName);
            $applicationVideo->video = $fileName;
        }

        $applicationVideo->application_id = $request->application;
        $applicationVideo->save();

        $flash_s = 'Data saved successfully!';
        session()->flash('flash_s', $flash_s);
        return response()->json(['status' => 200, 'title' => $flash_s, 'result' => ['next' => url(admin() . '/' . $this->titles->viewPathPrefix)]]);
    }

    public function destroy(ApplicationVideo $applicationVideo)
    {
        if(File::exists(ApplicationVideo::videoLocation().'/'.$applicationVideo->video)){
            File::delete(ApplicationVideo::videoLocation().'/'.$applicationVideo->video);
        }

        $applicationVideo->delete();
        $flash_s = 'Data deleted successfully!';
        return response()->json(['status' => 200, 'title' => $flash_s]);
    }

    public function validation(Request $request)
    {
        $validationData = [
            'application' => 'required',
            'video' => 'required',
        ];
        // if(request()->action == 'update'){
        //     $validationData['video'] = 'required';
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
        $data = ApplicationVideo::with('application')->get()->all();

        return datatables($data)
            ->addColumn('action', function ($row) {
                return '<a class="btn btn-sm btn-info" href="' . $this->titles->viewPathPrefix . '/' . $row->id . '/edit/"><i class="feather icon-edit"></i> Edit</a>
                        <a oncLick="confirmDelete(' . $row->id . ',\'Wallpaper\')" class="btn btn-sm btn-danger" href="javascript:void(0);"><i class="feather icon-trash-2"></i> Delete</a>';
            })->make();
    }
}
