<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use App\Models\Table;
use App\Models\WaitingList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $reservation;
    private $table;
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
        $this->table = new Table();
    }

    public function reserveTable(Request $request){
        $validation = Validator::make($request->all(), [
            'date'          => 'required|after:yesterday',
            'from_time'     => 'required',
            'to_time'       => 'required|after:from_time',
            'seats'         => 'required',
            'table_id'      => 'required|exists:tables,id',
            'customer_id'   => 'required|exists:customers,id'
        ]);

        if ($validation->fails()){
            return customResponse((object)[], 422, $validation->errors()->first());
        }


        $date = $request->date;
        $from_time = $request->from_time;
        $to_time = $request->to_time;
        $seats = $request->seats;

        // Checking again if the requested table still available , as it may be taken
        // during the period when user starts to select the table and now
        $availableTables = $this->table->availableTables($date, $from_time, $to_time, $seats, $request->table_id);
        if (!count($availableTables)){
            // Creating a record for the customer in waiting list table if he has no records
            WaitingList::firstOrCreate($request->only('customer_id'));
            return customResponse((object)[], 422, 'No tables available for this date and time, You were added to waiting list');
        }
        // Starting the Database transaction
        DB::beginTransaction();
        try {
            $reservation = $this->reservation->create($request->all());
            // Deleting customer record from waiting list if exists
            WaitingList::where('customer_id', $request->customer_id)->delete();
            // Committing database transaction if succeeded
            DB::commit();
        }catch (\Exception $exception){
            // Rolling back transaction when failure
            DB::rollBack();
        }

        return customResponse(new ReservationResource($reservation), 200);

    }
}
