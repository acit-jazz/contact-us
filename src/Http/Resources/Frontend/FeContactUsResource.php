<?php

namespace AcitJazz\Article\Http\Resources\Frontend;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class FeArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'summary' => $this->summary,
            'description' => $this->description,
            'status' => $this->status,
            'featured' => $this->featured,
            'tags' => ListTagResource::collection($this->tags)->resolve(),
            'banners' => $this->banners,
            'images' => $this->images,
            'meta'=> $this->meta ?? [
               'title' =>  '',
               'description' =>  '',
               'image' =>  '',
            ],
            'published_at' => $this->published_at ? Carbon::parse($this->published_at)->format('Y-m-d H:i') : null,
        ];
    }
}
