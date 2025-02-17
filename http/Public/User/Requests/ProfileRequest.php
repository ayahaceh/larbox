<?php

namespace Http\Public\User\Requests;

use App\Http\Requests\ActiveFormRequest;
use Modules\User\Models\User;

use Illuminate\Validation\Rule;
use App\Helpers\Validation\FileValidationHelper;
use Illuminate\Support\Facades\Hash;

class ProfileRequest extends ActiveFormRequest
{
    public function __construct()
    {
        if ($model = auth()->user()) {
            $this->model = $model;
        }

        return parent::__construct();
    }

    public function nonLocalizedRules()
    {
        return [
            'username' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9_\-]+$/',
                Rule::unique($this->model->getTable())->ignore($this->model->id),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique($this->model->getTable())->ignore($this->model->id),
            ],
            'new_password' => 'nullable|string|min:8,max:255',
            'new_password_confirmation' => [
                Rule::requiredIf(strlen($this->new_password) > 0),
                'same:new_password',
            ],

            'profile.full_name' => 'required|string|max:255',
            'profile.phone' => 'nullable|string|max:255',
            'profile.image' => FileValidationHelper::rules(FileValidationHelper::CONFIG_IMAGE),
        ];
    }

    public function validated($key = null, $default = null)
    {
        $data = parent::validated($key, $default);

        if ($this->new_password) {
            $data['password'] = Hash::make($this->new_password);
        }

        $this->model->fillableRelations = [
            $this->model::RELATION_TYPE_ONE_ONE => [
                'profile' => $data['profile'],
            ],
        ];

        return $data;
    }

    public function messages()
    {
        return [
            'username.regex' => __("Только латинские символы, цифры и (_-)"),
        ];
    }
}
