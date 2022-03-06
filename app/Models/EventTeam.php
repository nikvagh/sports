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
}
