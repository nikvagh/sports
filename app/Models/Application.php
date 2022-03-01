<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    use HasFactory;
    use SoftDeletes;

    public static function titles(){
        return (object) ['title'=>'Applications','viewPathPrefix'=>'applications','viewNamePrefix'=>'application','breadCrumbTitle'=>'Applications','titleSingular'=>'Application'];
    }

    public function applicationWallpapers()
    {
        return $this->hasMany(ApplicationWallpaper::class);
    }

    public function applicationVideos()
    {
        return $this->hasMany(ApplicationVideo::class);
    }
}
