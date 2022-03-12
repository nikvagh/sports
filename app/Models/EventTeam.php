<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventTeam extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $guarded = [];

    public static function titles($event_id=0){
        $title = ['title'=>'Event Teams','viewPathPrefix'=>'eventTeams','viewNamePrefix'=>'eventTeam','titleSingular'=>'Event Team'];
        if($event_id > 0){
            $event = Event::find($event_id);
            $title['breadCrumbTitle'] = $event->name.' - Event Teams';
        }else{
            $title['breadCrumbTitle'] = 'Event Teams';
        }
        return (object) $title;
    }

    public function team(){
        return $this->belongsTo(Team::class);
    }

    public function eventTeamPlayers(){
        return $this->hasMany(EventTeamPlayer::class);
    }

    public function eventPointTable(){
        return $this->hasOne(EventPointTable::class);
    }

    public function matches1()
    {
        return $this->hasMany(Matches::class,'event_team_id_1','id');
    }

    public function matches2()
    {
        return $this->hasMany(Matches::class,'event_team_id_2','id');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($row) {
            foreach($row->eventTeamPlayers as $val) {
                $val->delete();
            }
            foreach($row->eventPointTable as $val) {
                $val->delete();
            }
            foreach($row->matches1 as $val) {
                $val->delete();
            }
            foreach($row->matches2 as $val) {
                $val->delete();
            }
        });
    }
}
