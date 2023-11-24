<?php

namespace Tests\Feature;

use function Pest\Laravel\{seed, actingAs, get};
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    seed(\Database\Seeders\DatabaseSeeder::class);
    actingAs(\App\Models\User::first());
});

test('index', function () {
    $response = get(route('products.index'));
    $response
        ->assertInertia(fn(Assert $page) => $page
            ->component('Products/Index')
            ->has('products', 15, fn(Assert $page) => $page
                ->has('id')
                ->has('article')
                ->has('name')
                ->has('status_label')
                ->has('status')
                ->has('options', fn(Assert $page) => $page
                    ->has('color_name')
                    ->has('color_value')
                )
                ->has('created_at')
                ->has('deleted_at')
            )
            ->has('total')
        );
});
