<?php

namespace App\Repository\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

interface Filterable
{
    /**
     * @param QueryBuilder|Builder $builder
     * @param array $data
     * @param array $rules
     * @return Builder|QueryBuilder
     */
    public function filter(QueryBuilder|Builder $builder, array $data = [], array $rules = []): Builder|QueryBuilder;

    /**
     * @return array
     */
    public function filterRules(): array;

    /**
     * @return array
     */
    public function orderByRules(): array;

    /**
     * @param string|null $orderBy
     * @return array
     */
    public function parseOrderByQueryParam(?string $orderBy = null): array;

    /**
     * @param QueryBuilder|Builder $builder
     * @param array $rules
     * @return Builder|QueryBuilder
     */
    public function orderBy(QueryBuilder|Builder $builder, array $rules = []): Builder|QueryBuilder;
}
