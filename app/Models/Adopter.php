<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adopter extends Model
{
    protected $table = 'adopter';

    public function adoption()
    {
        return $this->hasMany(Adoption::class,'adopter_id');
    }
}
