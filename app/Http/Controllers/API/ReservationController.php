<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function reserveTable(Request $request){
        $validation = Validator::make($request->all(), [
            'date'          => 'required|after:yesterday',
            'from_time'     => 'required',
            'to_time'       => 'required|after:from_time',
            'seats'         => 'required'
        ]);

        if ($validation->fails()){
            return customResponse((object)[], 422, $validation->errors()->first());
        }


        $date = $request->date;
        $from_time = $request->from_time;
        $to_time = $request->to_time;
        $seats = $request->seats;

        $table = new Table();
        $availableTables = $table->availableTables($date, $from_time, $to_time, $seats, $request->table_id);
        if (!count($availableTables)){
            return customResponse((object)[], 422, 'No tables available for this date and time');
        }

        $reservation = new Reservation();
        $reservation->table_id = $request->table_id;
        $reservation->customer_id = $request->customer_id;
        $reservation->date = $date;
        $reservation->from_time = $from_time;
        $reservation->to_time = $to_time;
        $reservation->save();

        return customResponse(new ReservationResource($reservation), 200);

    }
}
