<?php

namespace App\Domains\Property\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Domains\Property\Http\Requests\PropertyFilterRequest;
use App\Domains\Property\Repositories\PropertyRepositoryContract;
use App\Domains\Property\Resources\PropertyResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PropertyController extends Controller
{
    public function __construct(
        private readonly PropertyRepositoryContract $repository
    ) {}

    public function index(PropertyFilterRequest $request): AnonymousResourceCollection
    {
        $filters = $request->toDTO();

        $properties = $this->repository->search($filters);

        return PropertyResource::collection($properties);
    }
}
