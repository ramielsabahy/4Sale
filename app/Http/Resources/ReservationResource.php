<?php

namespace App\Http\Resources;

use App\Http\Resources\BranchResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
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
            'table_id'  => $this->table_id,
            'customer'  => new CustomerResource($this->customer),
            'date'      => $this->date,
            'time_from'      => $this->from_time,
            'time_to'      => $this->to_time,
        ];
    }
}
