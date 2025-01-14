<?php

namespace App\Http\Resources\api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'sale_price' => $this->sale_price,
            'quantity' => $this->quantity,
            'sku' => $this->sku,
            'ribon' => $this->ribon,
            'productOptions' => $this->productOptions,
            'categories' => CategoryCollection::make($this->whenLoaded('categories')),
            'productImages' => ProductImagesCollection::make($this->whenLoaded('productImages')),
        ];
    }
}
