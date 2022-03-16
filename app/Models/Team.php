<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $guarded = [];

    protected $appends = ['logoUrl'];
    
    public static function titles(){
        return (object) ['title'=>'Teams','viewPathPrefix'=>'teams','viewNamePrefix'=>'team','breadCrumbTitle'=>'Teams','titleSingular'=>'Team'];
    }

    public static function logoLocation(){
        return storage_path('app/public/team');
    }

    public static function logoLocationAbs(){
        return url('storage/team');
    }

    public function getLogoUrlAttribute()
    {
        $url = "";
        if($this->logo != ""){
            $url = $this->logoLocationAbs()."/{$this->logo}";
        }
        return $url;
    }

    public function eventTeams()
    {
        return $this->hasMany(EventTeam::class);
    }

    public function teamPlayers()
    {
        return $this->hasMany(TeamPlayer::class);
    }

    public function eventAwards()
    {
        return $this->morphMany(EventAward::class, 'event_awardable');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($row) {

            foreach($row->eventTeams as $val) {
                $val->delete();
            }
            foreach($row->teamPlayers as $val) {
                $val->delete();
            }
        });
    }
    
}
