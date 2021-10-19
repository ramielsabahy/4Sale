<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'meal_id',
        'amount_to_pay',
    ];

    protected $table = 'order_details';
    protected $guarded = [];

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function meal(){
        return $this->belongsTo(Meal::class,'meal_id');
    }
}
