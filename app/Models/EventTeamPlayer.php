<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventTeamPlayer extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $guarded = [];

    public static function titles($event_id=0,$event_team_id=0){
        $title = ['title'=>'Event Team Players','viewPathPrefix'=>'eventTeamPlayers','viewNamePrefix'=>'eventTeamPlayer','titleSingular'=>'Event Team Player'];

        $event = Event::find($event_id);
        $breadCrumbTitle = '';
        if(isset($event->name)){
            $breadCrumbTitle .= $event->name;
        }

        $breadCrumbTitle .= ' - Event Team Players';
        
        if($event_team_id > 0){
            $eventTeam = eventTeam::with('team')->find($event_team_id);
            $breadCrumbTitle = $eventTeam->team->name.' - Event Team Players';
        }else{
            $breadCrumbTitle .= 'Event Team Players';
        }
        $title['breadCrumbTitle'] = $breadCrumbTitle;
        return (object) $title;
    }

    public function player(){
        return $this->belongsTo(Player::class);
    }

    public function eventTeam(){
        return $this->belongsTo(EventTeam::class);
    }
}
