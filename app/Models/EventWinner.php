<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventWinner extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $guarded = [];
    protected $appends = ['imageUrl'];

    public static function titles(){
        return (object) ['title'=>'Winners','viewPathPrefix'=>'eventWinners','viewNamePrefix'=>'eventWinner','breadCrumbTitle'=>'Winners','titleSingular'=>'Winner'];
    }

    public static function imageLocation(){
        return storage_path('app/public/application/winners');
    }
    
    public static function imageLocationAbs(){
        return url('storage/application/winners');
    }

    public function getImageUrlAttribute()
    {
        $url = "";
        if($this->image != ""){
            $url = $this->imageLocationAbs()."/{$this->image}";
        }
        return $url;
    }

    public function event(){
        return $this->belongsTo(Event::class);
    }

    public function team(){
        return $this->belongsTo(Team::class);
    }
}
