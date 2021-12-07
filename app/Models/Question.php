<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $table = 'questionnaire';
    public function adoption(){
        return $this->belongsTo(Adoption::class,'adoption_id');
    }  
}
