<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stadium extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'stadiums';
    protected $guarded = [];
    protected $appends = ['imageUrl'];
    
    public static function titles(){
        return (object) ['title'=>'Stadiums','viewPathPrefix'=>'stadiums','viewNamePrefix'=>'stadium','breadCrumbTitle'=>'Stadiums','titleSingular'=>'Stadium'];
    }

    public static function imageLocation(){
        return storage_path('app/public/stadium');
    }

    public static function imageLocationAbs(){
        return url('storage/stadium');
    }

    public function getImageUrlAttribute()
    {
        $url = "";
        if($this->image != ""){
            $url = $this->imageLocationAbs()."/{$this->image}";
        }
        return $url;
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function matches()
    {
        return $this->belongsTo(Matches::class);
    }
}
