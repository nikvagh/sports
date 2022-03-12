<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ApplicationWallpaper;
use App\Models\Game;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ApplicationWallpaperController extends Controller
{
    public function __construct()
    {
        $this->titles = ApplicationWallpaper::titles();
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
        $applicationWallpaper = new ApplicationWallpaper;

        $fileName = '';
        if($request->hasFile('wallpaper')){
            $fileName = str_replace(" ","_",time().'_'.$wallpaper->getClientOriginalName());
            $wallpaper->move(ApplicationWallpaper::wallpaperLocation(),$fileName);
        }
        $applicationWallpaper->wallpaper = $fileName;
        $applicationWallpaper->application_id = $application;

        $applicationWallpaper->save();

        $flash_s = 'Data saved successfully!';
        session()->flash('flash_s', $flash_s);
        return response()->json(['status' => 200, 'title' => $flash_s, 'result' => ['next' => url(admin() . '/' . $this->titles->viewPathPrefix)]]);
    }

    public function show(ApplicationWallpaper $applicationWallpaper)
    {
        //
    }

    public function edit(ApplicationWallpaper $applicationWallpaper)
    {
        $result['titles'] = $this->titles;
        $result['row'] = $applicationWallpaper;
        $result['applications'] = Application::get()->all();
        return view(backView() . '.' . $this->titles->viewNamePrefix . '_edit')->with($result);
    }

    public function update(Request $request, ApplicationWallpaper $applicationWallpaper)
    {
        extract(request()->all());

        if($request->hasFile('wallpaper')){
            if(File::exists(ApplicationWallpaper::wallpaperLocation().'/'.$applicationWallpaper->wallpaper)){
                File::delete(ApplicationWallpaper::wallpaperLocation().'/'.$applicationWallpaper->wallpaper);
            }

            $fileName = str_replace(" ","_",time().'_'.$wallpaper->getClientOriginalName());
            $wallpaper->move(ApplicationWallpaper::wallpaperLocation(),$fileName);
            $applicationWallpaper->wallpaper = $fileName;
        }

        $applicationWallpaper->application_id = $request->application;
        $applicationWallpaper->save();

        $flash_s = 'Data saved successfully!';
        session()->flash('flash_s', $flash_s);
        return response()->json(['status' => 200, 'title' => $flash_s, 'result' => ['next' => url(admin() . '/' . $this->titles->viewPathPrefix)]]);
    }

    public function destroy(ApplicationWallpaper $applicationWallpaper)
    {
        $applicationWallpaper->delete();
        $flash_s = 'Data deleted successfully!';
        return response()->json(['status' => 200, 'title' => $flash_s]);
    }

    public function validation(Request $request)
    {
        $validationData = [
            'application' => 'required',
            // 'wallpaper' => 'required',
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
        $data = ApplicationWallpaper::with('application')->get()->all();

        return datatables($data)
            ->addColumn('action', function ($row) {
                return '<a class="btn btn-sm btn-info" href="' . $this->titles->viewPathPrefix . '/' . $row->id . '/edit/"><i class="feather icon-edit"></i> Edit</a>
                        <a oncLick="confirmDelete(' . $row->id . ',\'Wallpaper\')" class="btn btn-sm btn-danger" href="javascript:void(0);"><i class="feather icon-trash-2"></i> Delete</a>';
            })->make();
    }
}
