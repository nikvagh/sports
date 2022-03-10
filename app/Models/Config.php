<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Config extends Model
{
    use HasFactory;
    use SoftDeletes;

    public static function titles(){
        return (object) ['title'=>'Configurations','viewPathPrefix'=>'configs','viewNamePrefix'=>'config','breadCrumbTitle'=>'Configurations','titleSingular'=>'Configuration'];
    }

    public static function allData()
    {
        $config_data = Config::all();
        $result = array();
        foreach ($config_data as $val) {
            $result[$val->name] = $val->value;
        }
        return $result;
    }
}
