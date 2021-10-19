<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Meal;
use App\Models\Order;
use App\Models\OrderDetail;
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
    private $order;
    private $orderDetails;
    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->orderDetails = new OrderDetail();
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
            $order = $this->order->create($request->except('meals'));
            $totalToBePaid = 0;
            foreach ($request->meals as $mealId){
                $meal = Meal::whereId($mealId)->first();
                if ($meal->quantity_available < 1){
                    return customResponse((object)[], 422, "Meal with id $mealId has ran out");
                }
                $this->orderDetails->create([
                    'order_id'  => $order->id,
                    'meal_id'   => $meal->id,
                    'amount_to_pay' => $meal->price - $meal->discount
                ]);

                $totalToBePaid += $meal->price - $meal->discount;
            }
            $order->total = $totalToBePaid;
            $order->save();
            DB::commit();
            return customResponse((object)[], 200, 'Order placed successfully');
        }catch (\Exception $exception){
            DB::rollBack();
            return customResponse((object)[], 500, $exception->getMessage());
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

        $order = $this->order->where(['table_id' => $request->table_id, 'customer_id' => $request->customer_id])
            ->where('paid', '=', 0)->first();
        $order->paid = 1;
        $order->save();

        return customResponse(new OrderResource($order), 200);
    }
}
