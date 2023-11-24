<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;

class ProductController
{
    public function index(Request $request, ProductService $service): \Illuminate\Http\JsonResponse
    {
        $products = $service->filteredProducts($request->input('options', []), $total);

        return response()->json([
            'products' => ProductResource::collection($products),
            'total' => $total,
        ]);
    }
}
