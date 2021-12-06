<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class AnimalShelter extends Model
{
    use Notifiable;
    
    protected $table ='animal_shelters';
    public function shelterPhoto()
    {
        return $this->hasMany(ValidDocuments::class,'shelter_id');
    }
    public function category(){
        return $this->hasMany(Category::class,'shelter_id');
    }
    public function vaccine()
    {
        return $this->hasMany(Vaccine::class,'shelter_id');
    }
    public function deworm()
    {
        return $this->hasMany(Deworm::class,'shelter_id');
    }
    public function animals(){
        return $this->hasMany(Animals::class,'shelter_id');
    }
    public function receipt()
    {
        return $this->hasMany(Receipt::class,'petowner_id');
    }

}
