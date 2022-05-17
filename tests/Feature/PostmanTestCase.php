<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Testing\TestResponse;
use Illuminate\Support\Arr;
use Illuminate\Http\Testing\File;

use Tests\CreatesApplication;

abstract class PostmanTestCase extends BaseTestCase
{
    use CreatesApplication;

    const REQUEST_METHOD_GET = 'GET';
    const REQUEST_METHOD_POST = 'POST';
    const REQUEST_METHOD_PUT = 'PUT';
    const REQUEST_METHOD_PATCH = 'PATCH';
    const REQUEST_METHOD_DELETE = 'DELETE';
    const REQUEST_METHOD_OPTIONS = 'OPTIONS';
    const REQUEST_METHOD_HEAD = 'HEAD';

    protected $defaultHeaders = [
        'Accept' => 'application/json',
    ];

    private string $baseUrl = '/api/ru';
    protected string $requestUrl;
    protected string $requestMethod;
    protected array $requestQuery = [];
    private string $requestQueryAsString;

    protected array $requestBody = [];
    private array $requestFiles = [];
    protected array $requestHeaders = [];
    protected array $authHeaders = [];

    protected TestResponse $response;

    protected function sendRequest(): TestResponse
    {
        $this->requestQueryAsString = http_build_query($this->requestQuery);

        $headers = array_merge($this->defaultHeaders, $this->requestHeaders, $this->authHeaders);

        return $this->call(
            method: $this->requestMethod,
            uri: "$this->baseUrl/$this->requestUrl?$this->requestQueryAsString",
            parameters: $this->requestBody,
            server: $this->transformHeadersToServerVars($headers),
        );
    }

    public function callBeforeApplicationDestroyedCallbacks()
    {
        $fileName = base_path('storage/larbox/tests/_postman.json');
        $oldItems = is_file($fileName) ? file_get_contents($fileName) : '[]';
        $oldItems = json_decode($oldItems, true);

        $target = $this->providedTests[0]->getTarget();

        $target = str_replace(['\\', '::'], '.', $target);
        $target = ltrim($target, 'Tests.Feature.Tests');
        $target = str_replace(['Test', 'test_'], '', $target);
        $target = str_replace('___', ' | ', $target);

        $items['host'] = url($this->baseUrl);

        $this->requestBody = Arr::dot($this->requestBody);

        foreach ($this->requestBody as $key => &$value) {
            if ($value instanceof File) {
                $this->requestFiles[$key] = $value->name;
                unset($this->requestBody[$key]);
            }
        }

        $this->requestQuery = $this->convertDataToSingleDimensionalArray($this->requestQuery);

        $this->requestBody = Arr::undot($this->requestBody);
        $this->requestBody = $this->convertDataToSingleDimensionalArray($this->requestBody);

        $this->requestFiles = Arr::undot($this->requestFiles);
        $this->requestFiles = $this->convertDataToSingleDimensionalArray($this->requestFiles);

        $items[$target] = [
            'is_request' => true,
            'request' => [
                'headers' => $this->requestHeaders,
                'body' => $this->requestBody,
                'files' => $this->requestFiles,
                'method' => $this->requestMethod,
                'url' => [
                    'path' => $this->requestUrl,
                    'query' => $this->requestQuery,
                    'raw' => $this->requestQueryAsString ? "$this->requestUrl?$this->requestQueryAsString" : $this->requestUrl,
                ],
            ],
            'response' => [
                'headers' => $this->response->baseResponse->headers->allPreserveCase(),
                'body' => json_decode($this->response->baseResponse->content(), true),
                'status' => [
                    'code' => $this->response->baseResponse->status(),
                    'text' => $this->response->baseResponse->statusText(),
                ],
            ],
        ];

        $items = array_merge($oldItems, $items);
        $items = json_encode($items, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

        // file_put_contents($fileName, $items);

        parent::callBeforeApplicationDestroyedCallbacks();
    }

    private function convertDataToSingleDimensionalArray(array $data)
    {
        $data = urldecode(http_build_query($data));
        $data = explode('&', $data);
        $data = array_map(fn ($value) => explode('=', $value), $data);
        $data = Arr::pluck($data, 1, 0);
        $data = array_filter($data);

        return $data;
    }
}
