<?php

namespace Http\Admin\Section\Tests;

use App\Helpers\Test\Feature\FormHelper;

class LayoutTest extends _TestCase
{
    public function test_show()
    {
        $this->requestUrl .= '/layout';
        $this->requestMethod = self::REQUEST_METHOD_GET;

        $this->response = $this->sendRequest();
        $this->response->assertStatus(200);
    }

    public function test_update()
    {
        $this->requestUrl .= '/layout';
        $this->requestMethod = self::REQUEST_METHOD_PUT;

        $this->requestBody = [
            'header_phone' => '+998 00 000 00 01',

            'footer_phone' => '+998 00 000 00 02',
            'footer_copyright' => FormHelper::localized('Copyright'),
        ];

        $this->response = $this->sendRequest();
        $this->response->assertStatus(200);
    }
}
