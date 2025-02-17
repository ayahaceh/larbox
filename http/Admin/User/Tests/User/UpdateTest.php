<?php

namespace Http\Admin\User\Tests\User;

use App\Helpers\Test\Feature\FormHelper;

class UpdateTest extends _TestCase
{
    public string $requestMethod = self::REQUEST_METHOD_PUT;

    public function test_success()
    {
        $this->requestUrl .= '/1';

        $this->requestBody = [
            'username' => 'admin',
            'email' => 'admin@local.host',
            'role' => 'admin',
            'new_password' => 'admin123',
            'new_password_confirmation' => 'admin123',

            'profile' => [
                'full_name' => 'Administrator',
                'phone' => '+998000000001',
                'image' => FormHelper::file(),
            ],
        ];

        $this->response = $this->sendRequest();
        $this->response->assertStatus(200);
    }

    public function test_superadmin_role_is_unchangeable()
    {
        $this->requestUrl .= '/1';

        $this->requestBody = [
            'role' => 'registered',
        ];

        $this->response = $this->sendRequest();
        $this->response->assertStatus(422);
    }
}
