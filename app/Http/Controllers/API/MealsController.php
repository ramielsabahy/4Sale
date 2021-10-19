<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\MealsResource;
use Illuminate\Support\Facades\DB;

class MealsController extends Controller
{
    public function listMeals(){
        $meals = DB::select('SELECT * FROM `meals` where `quantity_available` > 0');
        return customResponse(MealsResource::collection($meals), 200);
    }
}
