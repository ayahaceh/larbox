<?php

namespace Modules\Box\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VariationResource extends JsonResource
{
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
