<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventPointTable extends Model
{
    use HasFactory;

    public function eventTeam(){
        return $this->belongsTo(EventTeam::class);
    }
}
