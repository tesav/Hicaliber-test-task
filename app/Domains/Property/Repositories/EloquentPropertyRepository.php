<?php

namespace App\Domains\Property\Repositories;

use App\Domains\Property\DTO\PropertyFilterDTO;
use App\Domains\Property\Entities\Property as PropertyEntity;
use App\Domains\Property\Models\Property as PropertyModel;
use App\Domains\Property\Repositories\PropertyRepositoryContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class EloquentPropertyRepository implements PropertyRepositoryContract
{
    public function search(PropertyFilterDTO $filter): LengthAwarePaginator
    {
        $query = PropertyModel::query();

        if ($filter->name) $query->where('name', 'ILIKE', "%{$filter->name}%");
        if ($filter->bedrooms !== null) $query->where('bedrooms', $filter->bedrooms);
        if ($filter->bathrooms !== null) $query->where('bathrooms', $filter->bathrooms);
        if ($filter->storeys !== null) $query->where('storeys', $filter->storeys);
        if ($filter->garages !== null) $query->where('garages', $filter->garages);
        if ($filter->priceMin !== null) $query->where('price', '>=', $filter->priceMin);
        if ($filter->priceMax !== null) $query->where('price', '<=', $filter->priceMax);

        if ($filter->sortBy && in_array($filter->sortBy, PropertyModel::SORTABLE_FIELDS)) {
            $query->orderBy($filter->sortBy, $filter->sortOrder);
        }

        $paginator = $query->paginate($filter->perPage);

        // Transform Eloquent models to Domain Entities
        $paginator->getCollection()->transform(fn(PropertyModel $model) => new PropertyEntity(
            id: $model->id,
            name: $model->name,
            bedrooms: $model->bedrooms,
            bathrooms: $model->bathrooms,
            storeys: $model->storeys,
            garages: $model->garages,
            price: $model->price,
        ));

        return $paginator;
    }

    public function save(PropertyEntity $entity): void
    {
        PropertyModel::updateOrCreate(
            ['name' => $entity->name],
            [
                'price' => $entity->price,
                'bedrooms' => $entity->bedrooms,
                'bathrooms' => $entity->bathrooms,
                'storeys' => $entity->storeys,
                'garages' => $entity->garages,
            ]
        );
    }

    public function saveBulk(array $entities): void
    {
        $rows = array_map(fn(PropertyEntity $p) => [
            'name' => $p->name,
            'price' => $p->price,
            'bedrooms' => $p->bedrooms,
            'bathrooms' => $p->bathrooms,
            'storeys' => $p->storeys,
            'garages' => $p->garages,
        ], $entities);

        PropertyModel::upsert($rows, ['name'], ['price', 'bedrooms', 'bathrooms', 'storeys', 'garages']);
    }
}
