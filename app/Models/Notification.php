<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    // protected $appends = ['iconUrl'];

    public static function titles(){
        return (object) ['title'=>'Notifications','viewPathPrefix'=>'notifications','viewNamePrefix'=>'notification','breadCrumbTitle'=>'Notifications','titleSingular'=>'Notification'];
    }

    public static function iconLocation(){
        return storage_path('app/public/icon');
    }

    public static function iconLocationAbs(){
        return url('storage/icon');
    }

    // public function getIconUrlAttribute()
    // {
    //     $url = "";
    //     if($this->profile != ""){
    //         $url = $this->profileLocationAbs()."/{$this->profile}";
    //     }
    //     return $url;
    // }
}
