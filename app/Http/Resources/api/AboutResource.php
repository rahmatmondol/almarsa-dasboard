<?php

namespace App\Http\Resources\api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AboutResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'banner_background' => $this->banner_background,
            'banner_title' => $this->banner_title,
            'banner_image' => $this->banner_image,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'about' => $this->about,
            'title' => $this->title,
            'sub_title' => $this->sub_title,
            'icons' => $this->icons,
            'image_cards' => $this->image_cards,
            'content' => $this->content,
        ];
    }
}
