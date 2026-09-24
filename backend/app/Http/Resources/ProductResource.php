<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'        => $this->id,
            'title'     => $this->title,
            'slug'      => $this->slug,
            'type'      => $this->type,
            'price'     => (float) $this->base_price,
            'days'      => $this->duration_days,
            'provinces' => $this->whenLoaded('destinations', 
                fn () => $this->destinations->pluck('province')->unique()->values()
            ),
            'rating'    => round((float) ($this->reviews_avg_rating ?? 0), 1),
            'links'     => ['self' => route('products.show', $this->slug)],
        ];
    }
}