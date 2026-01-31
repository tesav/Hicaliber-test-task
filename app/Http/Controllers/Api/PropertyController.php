<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PropertyResource;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PropertyController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Property::query()->filter($request->all());

        // Sorting
        $sortBy = $request->input('sort_by');
        if (in_array($sortBy, Property::SORTABLE_FIELDS)) {
            $order = $request->input('sort_order') === 'desc' ? 'desc' : 'asc';
            $query->orderBy($sortBy, $order);
        }

        // Pagination with max 100 records
        $perPage = min((int)$request->input('per_page', 10), 100);

        return PropertyResource::collection($query->paginate($perPage));
    }
}
