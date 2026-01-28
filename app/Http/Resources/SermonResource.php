<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class SermonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'title' => $this->title,
            'slug' => $this->slug,
            'main_verse' => $this->main_verse,
            'sermon_date' => $this->sermon_date,
            'youtube_link' => $this->youtube_link,
            'content' => $this->content,
            'pastor' => $this->when($this->pastor, function () {
                $pictureUrl = $this->pastor->picture_url;

                if ($pictureUrl && !str_starts_with($pictureUrl, 'http')) {
                    $pictureUrl = Storage::disk('public')->url($pictureUrl); // -> /storage/...
                }
                return [
                    'uuid' => $this->pastor->uuid,
                    'name' => $this->pastor->name,
                    'picture_url' => $pictureUrl,
                    'bio' => $this->pastor->bio,
                ];
            }),
            'tags' => $this->whenLoaded('tags', function () {
                return $this->tags->map(fn($tag) => [
                    'uuid' => $tag->uuid,
                    'name' => $tag->name,
                    'slug' => $tag->slug,
                    'hex_color' => $tag->hex_color,
                ]);
            }),
            'author' => $this->when($this->author, function () {
                return [
                    'uuid' => $this->author->uuid,
                    'name' => $this->author->name,
                ];
            }),
            'created_at' => $this->created_at,
        ];
    }
}
