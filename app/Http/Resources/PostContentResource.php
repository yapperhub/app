<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostContentResource extends JsonResource
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
            'slug' => $this->slug,
            'canonical_url' => $this->canonical_url,
            'excerpt' => $this->content->excerpt,
            'content' => $this->content->content,
            'featured_image' => $this->content->featured_image,
            'tags' => $this->tags->pluck('name'),
            'status' => $this->content->isPublished() ? 'published' : 'draft',
            'published_at' => $this->content->published_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->content->updated_at,
        ];
    }
}
