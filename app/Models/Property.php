<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    const SORTABLE_FIELDS = [
        'name',
        'price',
        'bedrooms',
        'bathrooms',
        'storeys',
        'garages'
    ];

    protected $fillable = [
        'name',
        'price',
        'bedrooms',
        'bathrooms',
        'storeys',
        'garages',
    ];

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        if (!empty($filters['name'])) {
            $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($filters['name']) . '%']);
        }

        foreach (['bathrooms', 'bedrooms', 'storeys', 'garages'] as $field) {
            if (isset($filters[$field])) {
                $query->where($field, (int)$filters[$field]);
            }
        }

        if (!empty($filters['price_min'])) {
            $query->where('price', '>=', (int)$filters['price_min']);
        }

        if (!empty($filters['price_max'])) {
            $query->where('price', '<=', (int)$filters['price_max']);
        }

        return $query;
    }
}
