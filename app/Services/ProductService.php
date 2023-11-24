<?php

declare(strict_types=1);

namespace App\Services;

use App\DataObjects\Filters\ProductFilterData;
use App\Models\Product;

class ProductService
{
    /**
     * @param array $options
     * @param ?int $total
     *
     * @return \Illuminate\Support\Collection
     */
    public function filteredProducts(array $options, ?int &$total = 0): \Illuminate\Support\Collection
    {
        $filters = ProductFilterData::from($options['fields'] ?? []);

        $productsQ = Product::query()
            ->select(['id', 'article', 'name', 'status', 'options', 'created_at', 'deleted_at'])
            ->productFilters($filters);
        $total = $productsQ->count();
        $productsQ = $productsQ->withPagination($options['pagination'] ?? [])
            ->sort($options['sort'] ?? []);

        return $productsQ->get();
    }
}
