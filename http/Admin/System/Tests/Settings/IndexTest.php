<?php

namespace Http\Admin\System\Tests\Settings;

class IndexTest extends _TestCase
{
    public string $requestMethod = self::REQUEST_METHOD_GET;

    public function test_success()
    {
        $this->response = $this->sendRequest();
        $this->response->assertStatus(200);
    }
}
