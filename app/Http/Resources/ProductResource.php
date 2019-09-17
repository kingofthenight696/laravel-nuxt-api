<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
            'id' => $this->id,
            'category_id' => $this->category_id,
            'preview' => $this->preview,
            'avg_rating' => $this->avg_rating,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'price' => $this->price,
            'seo_title' => $this->seo_title,
            'seo_description' => $this->seo_description,
            'is_exist' => $this->is_exist,
            'views' => $this->views,
            'likes' => $this->likes,
            'images' => $this->images
        ];
    }
}
