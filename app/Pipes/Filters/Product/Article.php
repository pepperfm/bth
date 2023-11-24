<?php

declare(strict_types=1);

namespace App\Pipes\Filters\Product;

use App\Pipes\Filters\Filterable;

class Article
{
    public function handle(Filterable $filterable, \Closure $next)
    {
        $query = $filterable->query;
        /** @var \App\DataObjects\Filters\SessionFilterData $filters */
        $filters = $filterable->filters;

        $query->when(
            !empty($filters->article),
            static fn() => $query->where('article', 'like', "%$filters->article%")
        );

        return $next(Filterable::make($query, $filterable->filters));
    }
}
