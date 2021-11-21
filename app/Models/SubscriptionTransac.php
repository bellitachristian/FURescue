<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionTransac extends Model
{
    protected $table='subscription_transaction';

    public function subscription(){
        return $this->belongsTo(Subscription::class,'sub_id');
    }
    public function shelter(){
        return $this->belongsTo(AnimalShelter::class,'shelter_id');
    }
    public function petowner(){
        return $this->belongsTo(PetOwner::class,'petowner_id');
    }

}
