<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{

    public function __construct()
    {
        $this->titles = (object) ['title'=>'Profile','viewPathPrefix'=>'games','viewNamePrefix'=>'game','breadCrumbTitle'=>'Profile','titleSingular'=>'Profile'];
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

    public function edit()
    {
        $result['titles'] = $this->titles;
        $result['user'] = Auth::user();
        return view(backView().'.profile_edit')->with($result);
    }

    public function update(Request $request, User $User)
    {
        $User->name = $request->name;
        $User->email = $request->email;
        $User->save();

        $flash_s = 'Data saved successfully!';
        // session()->flash('flash_s',$flash_s); 
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
            'email' => 'required|email|unique:users,email,'.$request->id,
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'title' => 'Errors', 'result' => $validator->errors()->all()]);
        } else {
            return response()->json(['status' => 200]);
        }
    }

    public function changePassword(){
        $result['titles'] = $this->titles;
        $result['user'] = Auth::user();
        return view(backView().'.change_password')->with($result);
    }

    public function changePasswordValidation(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'new_confirm_password' => 'required|same:new_password'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'title' => 'Errors', 'result' => $validator->errors()->all()]);
        }

        $user = User::find(request()->id);
        if (!Hash::check($request->old_password, $user->password)) { 
            return response()->json(['status' => 310, 'title' => 'Errors', 'result' => ['Invalid Old password']]);
        }
        return response()->json(['status' => 200]);
    }

    public function changePasswordUpdate(Request $request, User $User)
    {
        $User->password = bcrypt($request->new_password);
        $User->save();

        $flash_s = 'Data saved successfully!';
        // session()->flash('flash_s',$flash_s); 
        return response()->json(['status' => 200, 'title' => $flash_s, 'result'=>['next'=>url(admin().'/'.$this->titles->viewPathPrefix)]]);
    }

}
