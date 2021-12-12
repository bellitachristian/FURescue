<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllocateDeworming extends Model
{
    protected $table ='allocatedeworm';
    public function animals(){
        return $this->belongsTo(Animals::class,'animal_id');
    }
    public function deworm(){
        return $this->belongsTo(Deworm::class,'dew_id');
    }
}
