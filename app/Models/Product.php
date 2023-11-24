<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use App\Builders\FilterBuilder;

class Product extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'article',
        'name',
        'status',
        'options',
    ];

    protected $casts = [
        'options' => 'array',
        'status' => \App\Enums\StatusEnum::class,
    ];

    /**
     * @param QueryBuilder $query
     *
     * @return FilterBuilder<\App\Models\Product>
     */
    public function newEloquentBuilder($query): FilterBuilder
    {
        return new FilterBuilder($query);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'available');
    }
}
