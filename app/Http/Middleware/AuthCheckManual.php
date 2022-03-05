<?php

namespace App\Http\Middleware;

use App\Models\Config;
use App\Models\Tenant;
use App\Models\User;
use App\Models\UserToken;
use Closure;
use DB;

class AuthCheckManual
{
    public function handle($request, Closure $next)
    {
        // echo "<pre>";
        // print_r($request->header());
        // echo "333";
        // exit;

        $token_text = $request->header('authorization');

        // check token
        if($token_text == ""){
            return response()->json(['status' => 401, 'title' => 'authorization required']);
        }
        $token = ltrim($token_text,'Bearer ');
        $token = trim($token);

        
        $apiToken = Config::where('name','api_token')->get()->first()->value;
        if($token != $apiToken){
            return response()->json(['status' => 401, 'title' => 'Invalid authorization.']);
        }

        return $next($request);
    }
}