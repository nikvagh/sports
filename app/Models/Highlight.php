<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Highlight extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $appends = ['videoUrl'];

    public static function videoLocation(){
        return storage_path('app/public/highlight');
    }

    public static function videoLocationAbs(){
        return url('storage/highlight');
    }

    public function getVideoUrlAttribute()
    {
        $url = "";
        if($this->video != ""){
            $url = $this->videoLocationAbs()."/{$this->video}";
        }
        return $url;
    }

    public function match()
    {
        return $this->belongsTo(Matches::class,'match_id','id');
    }

}
