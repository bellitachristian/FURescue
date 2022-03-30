<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AllocateDeworming;
use App\Models\AnimalShelter;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deworm extends Model
{
    use SoftDeletes;
    protected $table='deworm';

    public function allocatedeworm(){
        return $this->hasMany(AllocateDeworming::class, 'dew_id');
    }
}
