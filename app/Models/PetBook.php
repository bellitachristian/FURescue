<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetBook extends Model
{
    protected $table = 'petbook';

    public function Vaccinehistory(){
        return $this->hasMany(Vaccinehistory::class,'petbook_id');
    }
    public function Dewormhistory(){
        return $this->hasMany(Dewormhistory::class,'petbook_id');
    }
}
