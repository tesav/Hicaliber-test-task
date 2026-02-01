<?php

namespace App\Domains\Property\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Domains\Property\DTO\PropertyFilterDTO;

class PropertyFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string'],
            'bathrooms' => ['nullable', 'integer', 'min:0'],
            'bedrooms' => ['nullable', 'integer', 'min:0'],
            'storeys' => ['nullable', 'integer', 'min:0'],
            'garages' => ['nullable', 'integer', 'min:0'],
            'price_min' => ['nullable', 'integer', 'min:0'],
            'price_max' => ['nullable', 'integer', 'min:0'],
            'sort_by' => ['nullable', 'in:price,bedrooms,bathrooms,storeys,garages'],
            'sort_order' => ['nullable', 'in:asc,desc'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ];
    }

    public function toDTO(): PropertyFilterDTO
    {
        $v = $this->validated();

        return new PropertyFilterDTO(
            name: $v['name'] ?? null,
            bathrooms: $v['bathrooms'] ?? null,
            bedrooms: $v['bedrooms'] ?? null,
            storeys: $v['storeys'] ?? null,
            garages: $v['garages'] ?? null,
            priceMin: $v['price_min'] ?? null,
            priceMax: $v['price_max'] ?? null,
            sortBy: $v['sort_by'] ?? null,
            sortOrder: $v['sort_order'] ?? 'asc',
            perPage: min((int)($v['per_page'] ?? 10), 100),
        );
    }
}
