<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'table'     => new TableResource($this->table),
            'customer'  => new CustomerResource($this->customer),
            'reservation'=> new ReservationResource($this->reservation),
            'waiter'    => new WaiterResource($this->waiter),
            'total'     => doubleval($this->total),
            'details'   => OrderDetailsResource::collection($this->details),
            'paid'      => $this->paid ? true : false
        ];
    }
}
