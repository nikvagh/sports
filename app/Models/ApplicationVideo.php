<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationVideo extends Model
{
    use HasFactory;
    protected $appends = ['videoUrl'];

    public static function titles(){
        return (object) ['title'=>'Application Videos','viewPathPrefix'=>'applicationVideos','viewNamePrefix'=>'applicationVideo','breadCrumbTitle'=>'Application Videos','titleSingular'=>'Application Video'];
    }

    public static function videoLocation(){
        return storage_path('app/public/application/video');
    }
    
    public static function videoLocationAbs(){
        return url('storage/application/video');
    }

    public function getVideoUrlAttribute()
    {
        $url = "";
        if($this->video != ""){
            $url = $this->videoLocationAbs()."/{$this->video}";
        }
        return $url;
    }

    public function application(){
        return $this->belongsTo(Application::class);
    }
}
