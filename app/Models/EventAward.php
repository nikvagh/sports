<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventAward extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $guarded = [];
    
    public static function titles(){
        return (object) ['title'=>'Awards','viewPathPrefix'=>'eventAwards','viewNamePrefix'=>'eventAward','breadCrumbTitle'=>'Awards','titleSingular'=>'Award'];
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // public function event_awardable()
    // {
    //     return $this->morphTo();
    // }

    public function eventAwardHolders()
    {
        return $this->hasMany(EventAwardHolder::class);
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($row) {
            foreach($row->eventAwardHolders as $val) {
                $val->delete();
            }
        });
    }
}
