<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ConfigController extends Controller
{
    public function __construct()
    {
        $this->titles = Config::titles();
    }

    public function index()
    {
        $result['titles'] = $this->titles;
        $result['configs'] = Config::allData();
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

        $config = new Config;
        $config->name = $request->name;

        $config->save();

        $flash_s = 'Data saved successfully!';
        session()->flash('flash_s', $flash_s);
        return response()->json(['status' => 200, 'title' => $flash_s, 'result' => ['next' => url(admin() . '/' . $this->titles->viewPathPrefix)]]);
    }

    public function show(Config $config)
    {
        //
    }

    public function edit(Config $config)
    {
        $result['titles'] = $this->titles;
        $result['row'] = $config;
        return view(backView() . '.' . $this->titles->viewNamePrefix . '_edit')->with($result);
    }

    public function update(Request $request)
    {
        extract(request()->all());

        $save_data = ['api_token'];
        foreach($save_data as $key=>$val){
            $config = Config::where('name',$val)->get()->first();
            $config->value = $$val;
            $config->save();
        }

        $flash_s = 'Data saved successfully!';
        session()->flash('flash_s', $flash_s);
        return response()->json(['status' => 200, 'title' => $flash_s, 'result' => ['next' => url(admin() . '/' . $this->titles->viewPathPrefix)]]);
    }

    public function destroy(Config $config)
    {
        $config->delete();
        $flash_s = 'Data deleted successfully!';
        return response()->json(['status' => 200, 'title' => $flash_s]);
    }

    public function validation(Request $request)
    {
        // $validator = Validator::make(request()->all(), [
        //     'name' => 'required',
        // ]);
        // if ($validator->fails()) {
        //     return response()->json(['status' => 400, 'title' => 'Errors', 'result' => $validator->errors()->all()]);
        // } else {
            return response()->json(['status' => 200]);
        // }
    }

    public function list_data()
    {
        $data = Config::get()->all();

        return datatables($data)
            ->addColumn('action', function ($row) {
                return '<a class="btn btn-sm btn-info" href="' . $this->titles->viewPathPrefix . '/' . $row->id . '/edit/"><i class="feather icon-edit"></i> Edit</a>
                        <a oncLick="confirmDelete(' . $row->id . ',\'Config\')" class="btn btn-sm btn-danger" href="javascript:void(0);"><i class="feather icon-trash-2"></i> Delete</a>';
            })->make();
    }
}
