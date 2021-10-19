<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TableResource;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TableController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $table;
    public function __construct(Table $table)
    {
        $this->table = $table;
    }

    public function checkAvailability(Request $request){
        $v = Validator::make($request->all(), [
            'date'          => 'required|after:yesterday',
            'from_time'     => 'required',
            'to_time'       => 'required|after:from_time',
            'seats'         => 'required'
        ]);

        if ($v->fails()){
            return customResponse((object)[], 422, $v->errors()->first());
        }

        $date = $request->date;
        $from_time = $request->from_time;
        $to_time = $request->to_time;
        $seats = $request->seats;

        $availableTables = $this->table->availableTables($date, $from_time, $to_time, $seats);
        return customResponse([
            'available_tables'  => count($availableTables) ? true : false,
            'tables'            => TableResource::collection($availableTables)
        ], 200);

    }




}
