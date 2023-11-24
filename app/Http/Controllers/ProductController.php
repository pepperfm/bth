<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use App\Models\Product;

class ProductController
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Services\ProductService $service
     *
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function index(Request $request, ProductService $service): \Illuminate\Contracts\Support\Responsable
    {
        $products = $service->filteredProducts($request->input('options', []), $total);

        return Inertia::render('Products/Index', [
            'products' => ProductResource::collection($products),
            'total' => $total,
        ]);
    }

    public function create(): \Illuminate\Contracts\Support\Responsable|\Illuminate\Http\RedirectResponse
    {
        if (!auth()->user()->is_admin) {
            return to_route('home');
        }

        return Inertia::render('Products/Form', [
            'product' => [
                'id' => '',
                'name' => '',
                'status' => '',
                'options' => [
                    'color_name' => '',
                    'color_value' => '',
                ],
            ],
        ]);
    }

    /**
     * @param \App\Http\Requests\ProductRequest $request
     *
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function store(ProductRequest $request): \Illuminate\Contracts\Support\Responsable
    {
        return Inertia::render('Products/Index', [
            'products' => ProductResource::make(Product::create($request->validated())),
        ]);
    }

    /**
     * @param \App\Models\Product $product
     *
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function show(Product $product): \Illuminate\Contracts\Support\Responsable
    {
        return Inertia::render('Products/Form', [
            'product' => ProductResource::make($product),
        ]);
    }

    /**
     * @param \App\Http\Requests\ProductRequest $request
     * @param \App\Models\Product $product
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProductRequest $request, Product $product): \Illuminate\Http\RedirectResponse
    {
        $product->update($request->validated());

        return to_route('products.index');
        // return Inertia::render('Products/Index', [
        //     'product' => ProductResource::make($product),
        // ]);
    }

    /**
     * @param \App\Models\Product $product
     *
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function destroy(Product $product): \Illuminate\Contracts\Support\Responsable
    {
        $product->delete();

        return Inertia::render('Products/Index');
    }
}
