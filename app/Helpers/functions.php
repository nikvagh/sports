<?php
// use App\Models\Config;

use App\Models\Config;

if (!function_exists('curr_date')) {
    function curr_date()
    {
        return date('Y-m-d');
    }
}

if (!function_exists('curr_datetime')) {
    function curr_datetime()
    {
        return date('Y-m-d H:i:s');
    }
}

if (!function_exists('admin')) {
    function admin()
    {
        return config('constant.admin');
    }
}

function backView(){
    return config('constant.back');
}

function back_asset($path, $secure = null)
{
    return app('url')->asset(config('constant.back_asset') . '/' . $path, $secure);
}

function front_asset($path, $secure = null)
{
    return app('url')->asset(config('constant.front_asset') . '/' . $path, $secure);
}

if (!function_exists('otp_generate')) {
    function otp_generate($length_of_string)
    {
        $str_result = '0123456789';
        return substr(str_shuffle($str_result), 0, $length_of_string);
    }
}

if (!function_exists('unique_code')) {
    function unique_code($length_of_string)
    {
        $str_result = time() . '0123456789' . time();
        return substr(str_shuffle($str_result), 0, $length_of_string);
    }
}


if (!function_exists('referral_code_generate')) {
    function referral_code_generate($length_of_string)
    {
        $str_result = '0123456789abcdefghijklmnopqrstuvwxyz';
        return substr(str_shuffle($str_result), 0, $length_of_string);
    }
}

if (!function_exists('random_unique_str')) {
    function random_unique_str($length_of_string)
    {
        $str_result = time() . '0123456789abcdefghijklmnopqrstuvwxyz';
        return substr(str_shuffle($str_result), 0, $length_of_string);
    }
}

if (!function_exists('radius_distance')) {
    function radius_distance($lat1, $lon1, $lat2, $lon2, $unit = "K")
    {
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        } else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);

            if ($unit == "K") {
                return ($miles * 1.609344);
            } else if ($unit == "N") {
                return ($miles * 0.8684);
            } else {
                return $miles;
            }
        }
    }
}

if (!function_exists('sys_config_all')) {
    function sys_config_all()
    {
        $config_data = Config::get()->all();
        $result = array();
        foreach ($config_data as $val) {
            $result[$val->option] = $val->value;
        }
        return $result;
    }
}

if (!function_exists('sys_config')) {
    function sys_config($option)
    {
        $value = Config::select('option')->where('value', '=', $option)->get()->first()->option_val;
        return $value;
    }
}

if (!function_exists('random_unique_number')) {
    function random_unique_number($length_of_string)
    {
        $str_result = time() . '0123456789';
        return substr(str_shuffle($str_result), 0, $length_of_string);
    }
}

if (!function_exists('vendor_logo_url')) {
    function vendor_logo_url($img)
    {
        if ($img != "") {
            $url =  url('/' . config('constant.super_vendor_dir')) . '/' . $img;
        } else {
            $url = "";
        }

        return $url;
    }
}
