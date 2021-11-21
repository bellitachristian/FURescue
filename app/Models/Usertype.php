<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usertype extends Model
{
    protected $table ='usertype';

    public function shelter(){
        return $this->hasMany(AnimalShelter::class,'usertype_id');
    }
    public function petowner(){
        return $this->hasMany(PetOwner::class,'usertype_id');
    }
    public function admin(){
        return $this->hasMany(Admin::class,'usertype_id');
    }
    public function feedbacksender(){
        return $this->hasMany(Feedback::class,'sender');
    }
    public function feedbackreceiver(){
        return $this->hasMany(Feedback::class,'receiver');
    }

}
