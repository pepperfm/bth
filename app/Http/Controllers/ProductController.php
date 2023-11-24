<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Jobs\SendEmailJob;
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
                'article' => '',
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProductRequest $request): \Illuminate\Http\RedirectResponse
    {
        SendEmailJob::dispatch(
            Product::create($request->validated())
        );

        return to_route('products.index');
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
    }

    /**
     * @param Product $product
     * @param ProductService $service
     *
     * @return Responsable
     */
    public function destroy(Product $product, ProductService $service): \Illuminate\Contracts\Support\Responsable
    {
        $product->delete();
        $products = $service->filteredProducts(request()->input('options', []), $total);

        return Inertia::render('Products/Index', [
            'products' => ProductResource::collection($products),
            'total' => $total,
        ]);
    }
}
