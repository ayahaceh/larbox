<?php

namespace Http\Admin\System\Tests\Language;

use App\Tests\Feature\Traits\Index\AvailableSortingsTrait;
use App\Tests\Feature\Traits\Index\AvailableRelationsTrait;
use App\Tests\Feature\Traits\Index\PaginationTrait;
use App\Tests\Feature\Traits\Index\ShowDeletedTrait;

use Modules\System\Search\LanguageSearch;

class IndexTest extends _TestCase
{
    use AvailableSortingsTrait;
    use PaginationTrait;

    protected string $searchClass = LanguageSearch::class;

    protected string $requestMethod = self::REQUEST_METHOD_GET;

    public function test_available_filters()
    {
        $this->requestQuery = [
            'filter' => [
                'id' => 1,
                'name' => 'русский',
                'code' => 'ru',
                'is_active' => 1,
                'is_main' => 1,
            ],
        ];

        $this->response = $this->sendRequest();
        $this->response->assertStatus(206);
    }
}
