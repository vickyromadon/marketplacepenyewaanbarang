<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'id'                    => $this->id,
            'name'                  => $this->name,
            'quantity'              => $this->quantity,
            'price'                 => $this->price,
            'view'                  => $this->view,
            'description'           => $this->description,
            'terms_and_conditions'  => $this->terms_and_conditions,
            'deposite'              => $this->deposite,
            'time_periode'          => $this->time_periode,
            'created_at'            => $this->created_at,
            'user'                  => new FileResource($this->whenLoaded('user')),
            'file'                  => new FileResource($this->whenLoaded('file')),
            'subcategory'           => new SubCategoryResource($this->whenLoaded('subcategory')),
            'location'              => new LocationResource($this->whenLoaded('location')),
            'rating'                => new RatingResource($this->whenLoaded('rating')),
        ];
    }
}
