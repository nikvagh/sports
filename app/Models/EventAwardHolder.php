<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventAwardHolder extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $guarded = [];
    
    public static function titles(){
        return (object) ['title'=>'Award Holders','viewPathPrefix'=>'eventAwardHolders','viewNamePrefix'=>'eventAwardHolder','breadCrumbTitle'=>'Award Holders','titleSingular'=>'Award Holder'];
    }

    public function eventAward()
    {
        return $this->belongsTo(EventAward::class);
    }

    // public function event()
    // {
    //     return $this->belongsTo(Event::class);
    // }

    public function eventTeamPlayer()
    {
        return $this->belongsTo(EventTeamPlayer::class);
    }
}
