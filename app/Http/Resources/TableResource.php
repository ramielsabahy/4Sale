<?php

namespace App\Http\Resources;

use App\Http\Resources\BranchResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TableResource extends JsonResource
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
            'capacity'  => intval($this->capacity)
        ];
    }
}
