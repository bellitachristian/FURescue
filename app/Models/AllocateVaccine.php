<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllocateVaccine extends Model
{
    protected $table ='allocatevaccine';
    public function animals(){
        return $this->belongsTo(Animals::class,'animal_id');
    }
    public function vaccine(){
        return $this->belongsTo(Vaccine::class,'vac_id');
    }
}
