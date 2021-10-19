<?php

namespace App\Http\Resources;

use App\Http\Resources\BranchResource;
use Illuminate\Http\Resources\Json\JsonResource;

class MealsResource extends JsonResource
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
            'price'     => doubleval($this->price),
            'description' => $this->description,
            'quantity_available'    => $this->quantity_available,
            'discount'  => $this->quantity_available
        ];
    }
}
