<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlayerRole extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $guarded = [];
    
    public static function titles(){
        return (object) ['title'=>'Player Roles','viewPathPrefix'=>'playerRoles','viewNamePrefix'=>'playerRole','breadCrumbTitle'=>'Player Roles','titleSingular'=>'Player Role'];
    }

    public function game(){
        return $this->belongsTo(Game::class);
    }
}
