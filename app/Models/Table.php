<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Table extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function reservations(){
        return $this->hasMany(Reservation::class, 'table_id');
    }

    public function orders(){
        return $this->hasMany(Order::class, 'table_id');
    }

    public function availableTables($date, $from, $to, $capacity, $tableId = null){
        if (isset($tableId)){
            $appendQuery = 'and id = '.$tableId;
        }else{
            $appendQuery = '';
        }
        $availableTables = DB::select("select * from `tables`
                                where `capacity` >= $capacity ".$appendQuery."
                                and not exists (select * from `reservations`
                                    where `tables`.`id` = `reservations`.`table_id`
                                    and date(`date`) = '$date'
                                    and (`from_time` between '$from' and '$to' or `to_time` between '$from' and '$to'
                                             or (`from_time` <= '$from' and `to_time` >= '$from'))
                                    )
                                    order by `capacity` DESC ");
        return collect($availableTables);

        // Eloquent ORM query for the same sql query above

//        return $this->where('capacity', '>=', $capacity)
//            ->whereDoesntHave('reservations', function($reservation) use ($date, $from, $to){
//                $reservation->whereDate('date', $date)->where(function($query) use ($from, $to){
//                    $query->whereBetween('from_time', [$from, $to])
//                        ->orWhereBetween('to_time', [$from, $to]);
//                });
//            })->toSql();
    }
}
