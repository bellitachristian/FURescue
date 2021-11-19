<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AllocateVaccine;
use App\Models\AnimalShelter;

class Vaccine extends Model
{
    protected $table ='vaccine';

    public function allocatevaccine(){
        return $this->hasMany(AllocateVaccine::class, 'vac_id');
    }
}
