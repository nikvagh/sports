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
}
