<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdoptionFee extends Model
{
    use HasFactory;

    protected $table = 'adoption_fee';

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
