<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table ='feedback';
    
    public function sender(){
        return $this->belongsTo(Usertype::class,'sender');
    }
    public function receiver(){
        return $this->belongsTo(Usertype::class,'receiver');
    }
    public function subscription(){
        return $this->belongsTo(Subscription::class,'sub_id');
    }

}
