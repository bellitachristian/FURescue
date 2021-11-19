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
        return $this->belongsTo(AnimalShelter::class,'id');
    }
    public function subscription(){
        return $this->belongsTo(Subscription::class);
    }

}
