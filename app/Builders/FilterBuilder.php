<?php

declare(strict_types=1);

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Pipeline;
use App\Pipes\Filters\Filterable;
use App\Pipes\Filters\Product\{Status, Article, Name};

/**
 * @template TModelClass of \App\Models\User
 * @template TModelClass of \App\Models\Session
 *
 * @extends Builder<\App\Models\User>
 * @extends Builder<\App\Models\Session>
 */
class FilterBuilder extends Builder
{
    /**
     * @param array<string, mixed> $pagination
     *
     * @return Builder
     */
    public function withPagination(array $pagination = []): Builder
    {
        $offset = (($pagination['page'] ?? 1) - 1) * ($pagination['limit'] ?? 15);

        $this->offset($offset)->limit($pagination['limit'] ?? 15);

        return $this;
    }

    /**
     * @param array<string, mixed> $sort
     *
     * @return Builder
     */
    public function sort(array $sort = []): Builder
    {
        $direction = filter_var($sort['order'] ?? 0, FILTER_VALIDATE_BOOLEAN) ? 'asc' : 'desc';
        $this->orderBy($this->resolveSortField($sort['field'] ?? 'id'), $direction);

        return $this;
    }

    /**
     * @param string $field
     *
     * @return string
     */
    public function resolveSortField(string $field): string
    {
        return match ($field) {
            'id' => 'id',
            default => $field,
        };
    }

    /**
     * @param \App\DataObjects\Filters\SessionFilterData $filters
     *
     * @return Builder
     */
    public function productFilters(\Spatie\LaravelData\Contracts\DataObject $filters): Builder
    {
        return Pipeline::send(
            Filterable::make($this, $filters)
        )->through([
            Article::class,
            Name::class,
            Status::class,
        ])->thenReturn()->query();
    }
}
