<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ReservationResource;
use App\Models\Meal;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
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

    public function order(Request $request){
        $validation = Validator::make($request->all(), [
            'table_id'      => 'required|exists:tables,id',
            'customer_id'   => 'required|exists:customers,id',
            'reservation_id'=> 'required|exists:reservations,id',
            'waiter_id'     => 'required|exists:waiters,id',
            'meals'         => 'required|array',
            'meals.*.id'    => 'required|exists:meals,id',
        ]);

        if ($validation->fails()){
            return customResponse((object)[], 422, $validation->errors()->first());
        }

        DB::beginTransaction();
        try {
            $order = new Order();
            $order->table_id = $request->table_id;
            $order->customer_id = $request->customer_id;
            $order->reservation_id = $request->reservation_id;
            $order->waiter_id = $request->waiter_id;
            $order->date = date('Y-m-d');
            $order->save();

            $totalToBePaid = 0;
            foreach ($request->meals as $mealId){
                $meal = Meal::whereId($mealId)->first();
                if ($meal->quantity_available < 1){
                    return customResponse((object)[], 422, "Meal with id $mealId has ran out");
                }
                $orderDetails = new OrderDetail();
                $orderDetails->order_id = $order->id;
                $orderDetails->meal_id = $meal->id;
                $orderDetails->amount_to_pay = $meal->price - $meal->discount;
                $orderDetails->save();
                $totalToBePaid += $meal->price - $meal->discount;
            }
            $order->total = $totalToBePaid;
            $order->save();
            DB::commit();
            return customResponse((object)[], 200, 'Order placed successfully');
        }catch (\Exception $exception){
            DB::rollBack();
            return customResponse((object)[], 500, "Error in DB transaction");
        }


    }

    public function invoice(Request $request){
        $validation = Validator::make($request->all(), [
            'table_id'      => 'required|exists:tables,id',
            'customer_id'   => 'required|exists:customers,id'
        ]);

        if ($validation->fails()){
            return customResponse((object)[], 422, $validation->errors()->first());
        }

        $order = Order::where(['table_id' => $request->table_id, 'customer_id' => $request->customer_id])
            ->where('paid', '=', 0)->first();
        $order->paid = 1;
        $order->save();

        return customResponse(new OrderResource($order), 200);
    }
}
