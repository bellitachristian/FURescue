<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;
    protected $table='receipt';

    public function adopter(){
        return $this->belongsTo(Adopter::class,'adopter_id');
    }
    public function animal(){
        return $this->belongsTo(Animals::class,'animal_id');
    }
    public function usertype(){
        return $this->belongsTo(Usertype::class,'usertype_id');
    }
    public function adoption(){
        return $this->belongsTo(Usertype::class,'adoption_id');
    }
    public function payment(){
        return $this->belongsTo(Usertype::class,'payment_id');
    }   
}
