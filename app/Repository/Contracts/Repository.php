<?php

namespace App\Repository\Contracts;

use App\Models\Contracts\Exportable;
use App\Models\Model;
use App\Repository\Concerns\FilterOnQueryBuilder;
use App\Repository\Concerns\IsViewable;
use App\Repository\Contracts\Interfaces\RepositoryInterface;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Throwable;

abstract class Repository implements RepositoryInterface
{
    use FilterOnQueryBuilder;
    use \App\Repository\Concerns\CanImport;
    use IsViewable;

    /**
     * @param array $filter
     * @return Arrayable|Collection|AbstractPaginator
     */
    public function index(array $filter = []): Arrayable|Collection|AbstractPaginator
    {
        return $this->builder()->paginate();
    }

    /**
     * @param array $attributes
     * @return Model|Builder
     */
    public function create(array $attributes): Builder|Model
    {
        return $this->builder()->create($attributes)->refresh();
    }

    /**
     * @param int $id
     * @param false $orFail
     * @return \Illuminate\Database\Eloquent\Collection|Model|Builder|Builder[]
     */
    public function find(int $id, bool $orFail = false): Builder|array|\Illuminate\Database\Eloquent\Collection|Model
    {
        $query = $this->builder();
        return $orFail ? $query->findOrFail($id) : $query->find($id);
    }

    /**
     * @param Model|int $model
     * @param array $attributes
     * @return bool|int
     */
    public function update(int|Model $model, array $attributes = []): bool|int
    {
        $id = ($model instanceof Model) ? $model->id : (int)$model;

        return $this->builder()->where('id', $id)->update($attributes);
    }

    /**
     * @param Model|int $model
     * @param bool $force
     * @return bool
     */
    public function delete(int|Model $model, bool $force = false): bool
    {
        $id = ($model instanceof Model) ? $model->id : (int)$model;

        $builder = $this->builder()->where('id', $id);

        return $force ? $builder->forceDelete() : $builder->delete();
    }

    /**
     * @return bool
     * @throws Throwable
     */
    public function export(): bool
    {
        $class = $this->resourceClass();

        /** @var Exportable $exportableEntity */
        $exportableEntity = new $class();

        throw_unless(
            $exportableEntity instanceof Exportable,
            ValidationException::withMessages(["this resource is not exportable"])
        );

        return false;
    }

    private function resourceClass(): string
    {
        $class = Str::beforeLast(class_basename(static::class), 'Repository');
        return "App\\Models\\$class";
    }

    /**
     * @return Builder
     */
    protected function builder(): Builder
    {
        return call_user_func([$this->resourceClass(), "query"]);
    }

    /**
     * @param Collection|Arrayable $data
     * @return array
     */
    public function format(Collection|Arrayable $data): array
    {
        return $this->formater()($data);
    }

    /**
     * @return callable
     */
    public function formater(): callable
    {
        return function (Collection|Arrayable|array $model): array {
            if ($model instanceof Model) {
                return $model->toArray();
            } elseif ($model instanceof Collection) {
                return $model->map($this->formater())->toArray();
            } elseif ($model instanceof Arrayable) {
                return $model->toArray();
            }
            return (array)$model;
        };
    }
}
