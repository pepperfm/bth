<?php

declare(strict_types=1);

namespace App\Pipes\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\LaravelData\Contracts\DataObject;

class Filterable
{
    /**
     * @param \App\Builders\FilterBuilder $query
     * @param \Spatie\LaravelData\Contracts\DataObject $filters
     */
    public function __construct(
        public Builder $query,
        public DataObject $filters,
    ) {
    }

    public static function make(
        Builder $query,
        DataObject $filters
    ): static {
        return new static($query, $filters);
    }

    public function query(): Builder|\App\Builders\FilterBuilder
    {
        return $this->query;
    }
}
