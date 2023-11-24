<?php

declare(strict_types=1);

namespace App\DataObjects\Filters;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class ProductFilterData extends Data
{
    public function __construct(
        public ?string $id = '',
        public ?string $article = '',
        public ?string $name = '',
        public ?string $status = '',
    ) {
    }
}
