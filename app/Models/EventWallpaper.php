<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventWallpaper extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $guarded = [];
    protected $appends = ['wallpaperUrl'];

    public static function titles(){
        return (object) ['title'=>'Wallpapers','viewPathPrefix'=>'eventWallpapers','viewNamePrefix'=>'eventWallpaper','breadCrumbTitle'=>'Wallpapers','titleSingular'=>'Wallpaper'];
    }

    public static function wallpaperLocation(){
        return storage_path('app/public/wallpaper');
    }
    
    public static function wallpaperLocationAbs(){
        return url('storage/wallpaper');
    }

    public function getWallpaperUrlAttribute()
    {
        $url = "";
        if($this->wallpaper != ""){
            $url = $this->wallpaperLocationAbs()."/{$this->wallpaper}";
        }
        return $url;
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
