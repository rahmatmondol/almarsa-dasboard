<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sub_total' => $this->sub_total,
            'total' => $this->total,
            'user_id' => $this->user_id,
            'cartItems' => CartItemCollection::make($this->whenLoaded('cartItems')),
            'user' => UserResource::make($this->whenLoaded('user')),
        ];
    }
}
