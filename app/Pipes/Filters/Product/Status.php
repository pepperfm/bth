<?php

declare(strict_types=1);

namespace App\Pipes\Filters\Product;

use App\Pipes\Filters\Filterable;
use Illuminate\Database\Eloquent\Builder;

class Status
{
    public function handle(Filterable $filterable, \Closure $next)
    {
        $query = $filterable->query;
        /** @var \App\DataObjects\Filters\SessionFilterData $filters */
        $filters = $filterable->filters;
        $query->when(
            !empty($filters->status),
            static fn() => $query->where('status', $filters->status)
        );

        return $next(Filterable::make($query, $filterable->filters));
    }
}
