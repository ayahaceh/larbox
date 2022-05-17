<?php

namespace Modules\Product\Resources;

use App\Resources\JsonResource;

class ProductSpecificationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => $this->created_at->format('d.m.Y H:i:s'),
            'updated_at' => $this->updated_at->format('d.m.Y H:i:s'),
            'is_deleted' => (bool)$this->deleted_at,

            'options' => ProductSpecificationOptionResource::collection($this->whenLoaded('options')),
        ];
    }
}
