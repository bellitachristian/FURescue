<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $table = 'subscription';

    protected $casts = [
        'sub_desc'=>'array'
    ];
    
    public function subscription_transaction(){
        return $this->hasMany(SubscriptionTransac::class,'sub_id');
    }
    public function proofpayment(){
        return $this->hasMany(UploadedPhotos::class, 'sub_id');
    }
    
} 
