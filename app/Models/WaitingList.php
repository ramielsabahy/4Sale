<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaitingList extends Model
{

    public $timestamps = false;

    protected $fillable = ['customer_id'];

    public function customer(){
        return $this->hasMany(Customer::class);
    }

}
