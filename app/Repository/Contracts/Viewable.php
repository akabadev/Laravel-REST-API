<?php

namespace App\Repository\Contracts;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder;

interface Viewable
{
    /**
     * @param array $filters
     * @return Arrayable|array
     */
    public function toView(array $filters = []): Arrayable|array;

    /**
     * @param Builder|EloquentBuilder|null $builder
     * @param array $filters
     * @return Builder|EloquentBuilder
     */
    public function viewableBuilder(Builder|EloquentBuilder|null $builder = null, array $filters = []): Builder|EloquentBuilder;

    /**
     * @return array
     */
    public function viewableColumns(): array;
}
