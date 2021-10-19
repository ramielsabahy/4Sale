<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\MealsResource;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MealsController extends Controller
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

    public function listMeals(){
        $meals = DB::select('SELECT * FROM `meals` where `quantity_available` > 0');
        return customResponse(MealsResource::collection($meals), 200);
    }
}
