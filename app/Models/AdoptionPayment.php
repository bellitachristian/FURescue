<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdoptionPayment extends Model
{
    use HasFactory;
    protected $table = 'adoption_payment';

    public function animals(){
        return $this->belongsTo(Animals::class,'animal_id');
    }
    public function adopter(){
        return $this->belongsTo(Adopter::class,'adopter_id');
    }
    public function usertype(){
        return $this->belongsTo(Usertype::class,'owner_type');
    }
}
