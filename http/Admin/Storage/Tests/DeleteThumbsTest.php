<?php

namespace Http\Admin\Storage\Tests;

class DeleteThumbsTest extends _TestCase
{
    public string $requestMethod = self::REQUEST_METHOD_DELETE;

    public function test_success()
    {
        $this->requestUrl .= '/cache/delete-thumbs';

        $this->response = $this->sendRequest();
        $this->response->assertStatus(200);
    }
}
