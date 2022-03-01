<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Player extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $guarded = [];
    protected $appends = ['profileUrl'];
    
    public static function titles(){
        return (object) ['title'=>'Players','viewPathPrefix'=>'players','viewNamePrefix'=>'player','breadCrumbTitle'=>'Players','titleSingular'=>'Player'];
    }

    public static function profileLocation(){
        return storage_path('app/public/player');
    }

    public static function profileLocationAbs(){
        return url('storage/player');
    }

    public function getProfileUrlAttribute()
    {
        $url = "";
        if($this->profile != ""){
            $url = $this->profileLocationAbs()."/{$this->profile}";
        }
        return $url;
    }

    public function teamPlayers()
    {
        return $this->hasMany(TeamPlayer::class);
    }

    public function eventAwards()
    {
        return $this->morphMany(EventAward::class, 'event_awardable');
    }

}
