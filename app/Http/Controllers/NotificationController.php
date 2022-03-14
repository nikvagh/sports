<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Notification;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->titles = Notification::titles();
    }

    public function index()
    {
        $result['titles'] = $this->titles;
        $result['applications'] = Application::all();
        // echo "<pre>";
        // print_r($result);exit;
        return view(backView() . '.' . $this->titles->viewNamePrefix)->with($result);
    }

    public function create()
    {
        $result['titles'] = $this->titles;
        return view(backView() . '.' . $this->titles->viewNamePrefix . '_add')->with($result);
    }

    public function store(Request $request)
    {
        extract(request()->all());

        $notification = new Notification;
        $notification->name = $request->name;

        $notification->save();

        $flash_s = 'Data saved successfully!';
        session()->flash('flash_s', $flash_s);
        return response()->json(['status' => 200, 'title' => $flash_s, 'result' => ['next' => url(admin() . '/' . $this->titles->viewPathPrefix)]]);
    }

    public function show(Notification $notification)
    {
        //
    }

    public function edit(Notification $notification)
    {
        $result['titles'] = $this->titles;
        $result['row'] = $notification;
        return view(backView() . '.' . $this->titles->viewNamePrefix . '_edit')->with($result);
    }

    public function update(Request $request)
    {
        extract(request()->all());

        $notification = (object) [];
        $fileSystem = new Filesystem;
        $fileSystem->cleanDirectory(Notification::iconLocation());
        if($request->hasFile('icon')){
            $fileName = str_replace(" ","_",time().'_'.$icon->getClientOriginalName());
            $icon->move(Notification::iconLocation(),$fileName);
            $notification->icon = Notification::iconLocationAbs().'/'.$fileName;
        }

        $application = Application::find($request->application);
        $deviceTokens = $application->deviceTokens()->get()->pluck('token')->toArray();

        // $notification->package_name = $application->package_name;
        $notification->title = $request->title;
        $notification->description = $request->description;
        $notification->deviceTokens = $deviceTokens;
        
        // echo "<pre>";
        // print_r($notification);
        // exit;

        // $save_data = ['api_token'];
        // foreach($save_data as $key=>$val){
        //     $notification = Notification::where('name',$val)->get()->first();
        //     $notification->value = $$val;
        //     $notification->save();
        // }

        $flash_s = 'Data saved successfully!';
        session()->flash('flash_s', $flash_s);

        $result['next'] = url(admin() . '/' . $this->titles->viewPathPrefix);
        $result['notification'] = $notification;

        return response()->json(['status' => 200, 'title' => $flash_s, 'result' => $result]);
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();
        $flash_s = 'Data deleted successfully!';
        return response()->json(['status' => 200, 'title' => $flash_s]);
    }

    public function validation(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'application' => 'required',
            'title' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'title' => 'Errors', 'result' => $validator->errors()->all()]);
        } else {
            return response()->json(['status' => 200]);
        }
    }

    public function list_data()
    {
        $data = Notification::get()->all();

        return datatables($data)
            ->addColumn('action', function ($row) {
                return '<a class="btn btn-sm btn-info" href="' . $this->titles->viewPathPrefix . '/' . $row->id . '/edit/"><i class="feather icon-edit"></i> Edit</a>
                        <a oncLick="confirmDelete(' . $row->id . ',\'Notification\')" class="btn btn-sm btn-danger" href="javascript:void(0);"><i class="feather icon-trash-2"></i> Delete</a>';
            })->make();
    }
}
