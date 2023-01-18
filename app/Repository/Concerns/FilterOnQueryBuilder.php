<?php

namespace App\Repository\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Str;

trait FilterOnQueryBuilder
{
    /**
     * @param QueryBuilder|Builder $builder
     * @param array $data
     * @param array $rules
     * @return Builder|QueryBuilder
     */
    public function filter(QueryBuilder|Builder $builder, array $data = [], array $rules = []): Builder|QueryBuilder
    {
        return collect($rules)->reduce(function (QueryBuilder|Builder $builder, array $rule) use (&$data) {
            $operator = data_get($rule, 'operator') ?: 'like';
            $column = data_get($rule, 'column');
            $field = data_get($rule, 'field');

            $value = data_get($data, $field);
            $value = 'like' === $operator && $value ? "%$value%" : $value;

            return $builder->when(
                $value,
                fn (QueryBuilder|Builder $builder, $value) => $builder->where($column, $operator, $value)
            );
        }, $builder);
    }

    /**
     * @param string|null $orderBy
     * @return array
     */
    final public function parseOrderByQueryParam(?string $orderBy = null): array
    {
        if (null === $orderBy) {
            return [];
        }

        $rules = collect($this->orderByRules());

        return collect(explode(',', $orderBy))
            ->map(function (string $order) use ($rules) {
                $isDesc = Str::startsWith($order, '-');
                $column = Str::afterLast($order, $isDesc ? '-' : '+');
                $tuple = $rules->first(fn ($rule) => $rule['field'] == $column ?? false);
                return [
                    'column' => !!$tuple ? $tuple['column'] : null,
                    'direction' => $isDesc ? 'desc' : 'asc',
                ];
            })
            ->filter(fn ($order) => !!$order['column'])
            ->unique('column')
            ->toArray();
    }

    /**
     * @param QueryBuilder|Builder $builder
     * @param array $rules
     * @return Builder|QueryBuilder
     */
    public function orderBy(QueryBuilder|Builder $builder, array $rules = []): Builder|QueryBuilder
    {
        return collect($rules)->reduce(
            fn (QueryBuilder|Builder $builder, $value) => $builder->orderBy($value['column'], $value['direction']),
            $builder
        );
    }

    /**
     * @return array
     */
    public function filterRules(): array
    {
        return [];
    }

    public function orderByRules(): array
    {
        return [];
    }
}
