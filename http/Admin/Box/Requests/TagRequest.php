<?php

namespace Http\Admin\Box\Requests;

use App\Http\Requests\ActiveFormRequest;

use Illuminate\Validation\Rule;
use App\Rules\UniqueRule;

class TagRequest extends ActiveFormRequest
{
    public function nonLocalizedRules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                new UniqueRule($this->model),
            ],
        ];
    }
}
