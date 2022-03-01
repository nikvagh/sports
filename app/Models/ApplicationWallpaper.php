<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicationWallpaper extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $guarded = [];
    protected $appends = ['wallpaperUrl'];

    public static function titles(){
        return (object) ['title'=>'Application Wallpapers','viewPathPrefix'=>'applicationWallpapers','viewNamePrefix'=>'applicationWallpaper','breadCrumbTitle'=>'Application Wallpapers','titleSingular'=>'Application Wallpaper'];
    }

    public static function wallpaperLocation(){
        return storage_path('app/public/application/wallpaper');
    }
    
    public static function wallpaperLocationAbs(){
        return url('storage/application/wallpaper');
    }

    public function getWallpaperUrlAttribute()
    {
        $url = "";
        if($this->wallpaper != ""){
            $url = $this->wallpaperLocationAbs()."/{$this->wallpaper}";
        }
        return $url;
    }

    public function application(){
        return $this->belongsTo(Application::class);
    }
}
