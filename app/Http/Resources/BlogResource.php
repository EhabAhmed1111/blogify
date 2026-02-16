<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
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
            'title' => $this->title,
            'content' => $this->content,
            // i need it to be auto generated
            'author' => new UserResource($this->whenLoaded('author')),
            'like_count' => $this->likesCount(),
            'comment_count' => $this->commentsCount(),
            'comments' => CommentResource::collection($this->comments()->with('user')->get()),
            // i need to make the blog invisible if this date is in future 
            // but i need author to access it 
            'publish_at' => $this->publish_at->format("Y-m-d H:i:s"),
        ];
    }
}
