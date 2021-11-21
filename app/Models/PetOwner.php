<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PetOwner extends Model
{
    use Notifiable;

    protected $table ='pet_owners';
    public function petownerPhoto()
    {
        return $this->hasMany(ValidDocuments::class,'petowner_id');
    }
    public function category(){
        return $this->hasMany(Category::class,'petowner_id');
    }

    public function animals(){
        return $this->hasMany(Animals::class,'petowner_id');

    }
    public function vaccine()
    {
        return $this->hasMany(Vaccine::class,'petowner_id');
    }
    public function deworm()
    {
        return $this->hasMany(Deworm::class,'petowner_id');
    }
    public function subscription()
    {
        return $this->hasMany(Subscription::class,'petowner_id');
    }
}
