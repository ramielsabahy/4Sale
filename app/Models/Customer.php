<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function reservations(){
        return $this->hasMany(Reservation::class,'customer_id');
    }

    public function orders(){
        return $this->hasMany(Order::class,'customer_id');
    }

}
