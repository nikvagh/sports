<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Matches extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $guarded = [];

    public static function titles(){
        return (object) ['title'=>'Matches','viewPathPrefix'=>'matches','viewNamePrefix'=>'match','breadCrumbTitle'=>'Matches','titleSingular'=>'Match'];
    }

    public function team1()
    {
        return $this->belongsTo(EventTeam::class,'event_team_id_1','id');
    }

    public function team2()
    {
        return $this->belongsTo(EventTeam::class,'event_team_id_2','id');
    }

    public function stadium()
    {
        return $this->belongsTo(Stadium::class);
    }

    public function highlight()
    {
        return $this->hasOne(Highlight::class,'match_id','id');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($row) {
            if($row->highlight){
                $row->highlight->delete();
            }
        });
    }
}
