<?php

namespace App\Repository;

use App\Models\Model;
use App\Models\Page;
use App\Repository\Contracts\Interfaces\PageRepositoryInterface;
use App\Repository\Contracts\Repository;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Throwable;

class PageRepository extends Repository implements PageRepositoryInterface
{

    /**
     * @param int|Model|Page $page
     * @param bool $force
     * @return bool
     * @throws Throwable
     */
    public function delete(int|Model|Page $page, bool $force = false): bool
    {
        throw_if(
            $page->menus()->exists(),
            ValidationException::withMessages(["action" => "One or Many Profiles belongs to this page"])
        );

        return parent::delete($page, $force);
    }

    /**
     * @param array $filters
     * @return Arrayable|array
     */
    public function toView(array $filters = []): Arrayable|array
    {
        $paginator = $this->viewableBuilder(Page::query(), $filters)->latest('pages.updated_at')->paginate();

        $data = collect($paginator->items())
            ->map(fn (Arrayable $page) => Arr::onlyRecursive($page->toArray(), $this->viewableColumns()));

        return new LengthAwarePaginator($data, $paginator->total(), $paginator->perPage(), ['path' => request()->path()]);
    }

    /**
     * @param Builder|EloquentBuilder|null $builder
     * @param array $filters
     * @return Builder|EloquentBuilder
     */
    public function viewableBuilder(EloquentBuilder|Builder|null $builder = null, array $filters = []): Builder|EloquentBuilder
    {
        $builder = $builder ?: $this->builder();

        return $this->orderBy(
            $this->filter($builder, Arr::except($filters, 'order-by'), $this->filterRules()),
            $this->parseOrderByQueryParam($filters['order-by'] ?? '')
        );
    }

    /**
     * @return array
     */
    public function viewableColumns(): array
    {
        return [
            'id',
            'code',
            'name',
            'description',
            'active',
            'payload'
        ];
    }

    /**
     * @return string[][]
     */
    public function filterRules(): array
    {
        return [
            ['field' => 'active', 'column' => 'pages.active', 'operator' => '='],
            ['field' => 'code', 'column' => 'pages.code', 'operator' => 'like'],
            ['field' => 'name', 'column' => 'pages.name', 'operator' => 'like'],
            ['field' => 'description', 'column' => 'pages.description', 'operator' => 'like'],
        ];
    }

    /**
     * @param string|null $orderBy
     * @return string[][]
     */
    public function orderByRules(?string $orderBy = null): array
    {
        return [
            ['field' => 'id', 'column' => 'pages.id'],
            ['field' => 'active', 'column' => 'pages.active'],
            ['field' => 'code', 'column' => 'pages.code'],
            ['field' => 'name', 'column' => 'pages.name'],
            ['field' => 'description', 'column' => 'pages.description'],
        ];
    }
}
