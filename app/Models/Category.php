<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'category';

    
    public function type(){
          return $this->hasMany(Type::class,'categ_id');
    }
    
    public function breed(){
        return $this->hasMany(Breed::class,'categ_id');
    }

    public function adoptionfee(){
        return $this->hasMany(AdoptionFee::class,'categ_id');
    }
    
}

