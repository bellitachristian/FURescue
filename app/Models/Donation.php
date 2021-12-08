<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $table = 'donation';

    public function adopter(){
        return $this->belongsTo(Adopter::class,'donor_id');
    }
}
