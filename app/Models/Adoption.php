<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adoption extends Model
{
    protected $table='adoption';    
    public function adopter()
    {
        return $this->belongsTo(Adopter::class,'adopter_id');
    }
    public function animals()
    {
        return $this->belongsTo(Animals::class,'animal_id');
    }
}

