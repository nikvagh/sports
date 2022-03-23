<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $guarded = [];
    // protected $fillable = ['name'];
    
    
    public static function titles(){
        return (object) ['title'=>'Events','viewPathPrefix'=>'events','viewNamePrefix'=>'event','breadCrumbTitle'=>'Events','titleSingular'=>'Event'];
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    public function stadiums()
    {
        return $this->hasMany(Stadium::class);
    }

    public function eventWallpapers()
    {
        return $this->hasMany(EventWallpaper::class);
    }

    public function eventAwards()
    {
        return $this->hasMany(EventAward::class);
    }
    
    public function eventTeams()
    {
        return $this->hasMany(EventTeam::class);
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($row) {
            foreach($row->stadiums as $val) {
                $val->delete();
            }
            foreach($row->eventWallpapers as $val) {
                $val->delete();
            }
            foreach($row->eventAwards as $val) {
                $val->delete();
            }
            foreach($row->eventTeams as $val) {
                $val->delete();
            }
        });
    }
}
