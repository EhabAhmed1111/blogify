<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'name' => $this->name,
            'profile_image_url' => $this->cloudinary_profile_image_url,
            'cover_image_url' => $this->cloudinary_cover_image_url,
            'bio' => $this->bio,
            'social_links' => $this->social_links,
        ];
    }
}
