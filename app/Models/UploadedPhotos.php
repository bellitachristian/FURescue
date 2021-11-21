<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadedPhotos extends Model
{
    protected $table ='uploaded_photos';
    
    public function animals(){
        return $this->belongsTo(Animals::class,'id');
    }
    public function shelter(){
        return $this->belongsTo(AnimalShelter::class,'shelter_id');
    }
    public function petowner(){
        return $this->belongsTo(PetOwner::class,'petowner_id');
    }
    public function subscription(){
        return $this->belongsTo(Subscription::class);
    }

}
