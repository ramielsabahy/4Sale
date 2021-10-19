<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'from_time',
        'to_time',
        'date',
        'table_id',
        'customer_id'
    ];

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function table(){
        return $this->belongsTo(Table::class);
    }


}
