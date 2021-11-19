<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValidDocuments extends Model
{
    protected $table ='valid_docu';
    
    public function shelter()
    {
        return $this->belongsTo(AnimalShelter::class);
    }
}
