<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

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
            'id'=> $this->id,
            'name'=> $this->name,
            'image' => $this->image,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'image_url' => Storage::url($this->image)
        ];
    }
}
