<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
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
            'id'            => $this->id,
            'code'          => $this->code,
            'start_rent'    => $this->start_rent,
            'end_rent'      => $this->end_rent,
            'quantity'      => $this->quantity,
            'status'        => $this->status,
            'reasson'       => $this->reasson,
            'created_at'    => $this->created_at,
            'product'       => new ProductResource($this->whenLoaded('product')),
            'file'          => new FileResource($this->whenLoaded('file')),
        ];
    }
}
