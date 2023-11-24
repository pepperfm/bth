<?php

declare(strict_types=1);

namespace App\Pipes\Filters\Product;

use App\Pipes\Filters\Filterable;

class Name
{
    public function handle(Filterable $filterable, \Closure $next)
    {
        $query = $filterable->query;
        /** @var \App\DataObjects\Filters\SessionFilterData $filters */
        $filters = $filterable->filters;

        $query->when(
            !empty($filters->name),
            static fn() => $query->whereRaw('LOWER(name) ilike ?', ['%' . strtolower($filters->name) . '%'])
        );

        return $next(Filterable::make($query, $filterable->filters));
    }
}
