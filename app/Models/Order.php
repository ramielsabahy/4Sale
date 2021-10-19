<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'table_id',
        'customer_id',
        'reservation_id',
        'waiter_id',
        'date',
    ];

    public function table(){
        return $this->belongsTo(Table::class);
    }

    public function reservation(){
        return $this->belongsTo(Reservation::class);
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function waiter(){
        return $this->belongsTo(Waiter::class);
    }

    public function details(){
        return $this->hasMany(OrderDetail::class, 'order_id');
    }
}
