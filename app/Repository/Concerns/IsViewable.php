<?php

namespace App\Repository\Concerns;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder;

trait IsViewable
{
    /**
     * @param array $filters
     * @return Arrayable|array
     */
    public function toView(array $filters = []): Arrayable|array
    {
        return $this->viewableBuilder($this->builder(), $filters)->get();
    }

    /**
     * @param Builder|EloquentBuilder|null $builder
     * @param array $filters
     * @return Builder|EloquentBuilder
     */
    public function viewableBuilder(Builder|EloquentBuilder|null $builder = null, array $filters = []): Builder|EloquentBuilder
    {
        return $builder;
    }

    /**
     * @return array
     */
    public function viewableColumns(): array
    {
        return [];
    }
}
