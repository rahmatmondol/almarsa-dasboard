<?php

namespace App\Http\Resources\api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
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
            'title' => $this->title,
            'content' => $this->content,
            'icons' => $this->icons,
        ];
    }
}
