<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;

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

    public function delete(){
        $this->assetDelete();
        parent::delete();
    }

    public function assetDelete(){
        if(File::exists(Highlight::videoLocation().'/'.$this->video)){
            File::delete(Highlight::videoLocation().'/'.$this->video);
        }
    }
}
