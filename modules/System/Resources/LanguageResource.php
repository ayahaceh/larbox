<?php

namespace Modules\System\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LanguageResource extends JsonResource
{
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
