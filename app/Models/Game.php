<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Game extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    public $viewNamePrefix;
    public $title;

    protected $guarded = [];
    // protected $fillable = ['name'];
    
    public static function titles(){
        return (object) ['title'=>'Games','viewPathPrefix'=>'games','viewNamePrefix'=>'game','breadCrumbTitle'=>'Games','titleSingular'=>'Game'];
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function playerRoles()
    {
        return $this->hasMany(PlayerRole::class);
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($row) {
            foreach($row->events as $val) {
                $val->delete();
            }
            foreach($row->playerRoles as $val) {
                $val->delete();
            }
        });
    }
}
