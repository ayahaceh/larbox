<?php

namespace Modules\Region\Http\Admin\Controllers;

use App\Http\Controllers\ApiResourceController;

use Modules\Region\Models\Region;
use Modules\Region\Search\RegionSearch;
use Modules\Region\Resources\RegionResource;
use Modules\Region\Http\Admin\Requests\RegionRequest;

class RegionController extends ApiResourceController
{
    public function __construct()
    {
        return parent::__construct(
            model: new Region(),
            search: new RegionSearch(),
            resourceClass: RegionResource::class
        );
    }

    public function store(RegionRequest $request)
    {
        return $this->save($request, 201);
    }

    public function update(RegionRequest $request)
    {
        return $this->save($request, 200);
    }
}
