<?php

namespace App\Repository;

use App\Models\Model;
use App\Models\Profile;
use App\Models\User;
use App\Repository\Contracts\Interfaces\UserRepositoryInterface;
use App\Repository\Contracts\Repository;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

/**
 * Class UserRepository
 * @package App\Repository
 */
class UserRepository extends Repository implements UserRepositoryInterface
{
    /**
     * @param array $attributes
     * @return EloquentBuilder|Model
     */
    public function create(array $attributes): EloquentBuilder|Model
    {
        $attributes['profile_id'] = Profile::findByColumn('code', $attributes['profile_code'])->id;

        unset($attributes['profile_code']);

        return $this->builder()->updateOrCreate($attributes);
    }

    /**
     * @param int|Model $model
     * @param array $attributes
     * @return bool|int
     */
    public function update(int|Model $model, array $attributes = []): bool|int
    {
        if ($attributes['profile_code'] ?? false) {
            $attributes['profile_id'] = Profile::findByColumn("code", $attributes["profile_code"])->id;
        }

        return $model->refresh()->update($attributes);
    }

    /**
     * @param array $filters
     * @return Arrayable|array
     */
    public function toView(array $filters = []): Arrayable|array
    {
        $paginator = $this->viewableBuilder(User::query(), $filters)->latest('users.updated_at')->paginate();

        $data = collect($paginator->items())
            ->map(fn (Arrayable $user) => Arr::onlyRecursive($user->toArray(), $this->viewableColumns()));

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

        $builder->select('users.*')->with('profile')
            ->join('profiles', 'profiles.id', 'profile_id');

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
            'name',
            'email',
            'active',

            'profile.id',
            'profile.code',
            'profile.name',
            'profile.level',
            'profile.active'
        ];
    }

    /**
     * @return string[][]
     */
    public function filterRules(): array
    {
        return [
            ['field' => 'active', 'column' => 'users.active', 'operator' => '='],
            ['field' => 'email', 'column' => 'users.email', 'operator' => 'like'],
            ['field' => 'name', 'column' => 'users.name', 'operator' => 'like'],
            ['field' => 'profile.code', 'column' => 'profiles.code', 'operator' => 'like'],
            ['field' => 'profile.name', 'column' => 'profiles.name', 'operator' => 'like'],
        ];
    }

    /**
     * @param string|null $orderBy
     * @return string[][]
     */
    public function orderByRules(?string $orderBy = null): array
    {
        return [
            ['field' => 'id', 'column' => 'users.id'],
            ['field' => 'active', 'column' => 'users.active'],
            ['field' => 'email', 'column' => 'users.email'],
            ['field' => 'name', 'column' => 'users.name'],
            ['field' => 'profile_id', 'column' => 'profiles.id'],
            ['field' => 'profile_code', 'column' => 'profiles.code']
        ];
    }
}
