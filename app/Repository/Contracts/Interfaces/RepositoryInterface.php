<?php

namespace App\Repository\Contracts\Interfaces;

use App\Models\Model;
use App\Repository\Contracts\CanImport;
use App\Repository\Contracts\Filterable;
use App\Repository\Contracts\Viewable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Collection;

interface RepositoryInterface extends CanImport, Filterable, Viewable
{
    /**
     * @param array $filter
     * @return Arrayable|Collection|AbstractPaginator
     */
    public function index(array $filter = []): Arrayable|Collection|AbstractPaginator;

    /**
     * @param array $attributes
     * @return Builder|\Illuminate\Database\Eloquent\Model
     */
    public function create(array $attributes): Builder|\Illuminate\Database\Eloquent\Model;

    /**
     * @param int $id
     * @param false $orFail
     * @return Builder|array|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function find(int $id, bool $orFail = false): Builder|array|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null;

    /**
     * @param Model|int $model
     * @param array $attributes
     * @return bool|int
     */
    public function update(Model|int $model, array $attributes = []): bool|int;

    /**
     * @param Model|int $model
     * @param bool $force
     * @return bool
     */
    public function delete(Model|int $model, bool $force = false): bool;

    /**
     * @return bool
     */
    public function export(): bool;

    /**
     * @param Model|Collection|Arrayable $data
     * @return array
     */
    public function format(Model|Collection|Arrayable $data): array;

    /**
     * @return callable
     */
    public function formater(): callable;
}
