<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'article' => $this->faker->unique()->word(),
            'name' => $this->faker->name(),
            'status' => $this->faker->randomElement(\App\Enums\StatusEnum::cases()),
            'options' => [
                'color_name' => $this->faker->colorName(),
                'color_value' => $this->faker->hexColor(),
            ],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
