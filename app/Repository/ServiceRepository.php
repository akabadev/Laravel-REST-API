<?php

namespace App\Repository;

use App\Models\Address;
use App\Models\Model;
use App\Models\Service;
use App\Repository\Contracts\Interfaces\ServiceRepositoryInterface;
use App\Repository\Contracts\Repository;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Validation\UnauthorizedException;
use Throwable;

/**
 * Class ServiceRepository
 * @package App\Repository
 */
class ServiceRepository extends Repository implements ServiceRepositoryInterface
{
    /**
     * @param array $attributes
     * @return EloquentBuilder|Model
     */
    public function create(array $attributes): EloquentBuilder|Model
    {
        if (!($attributes['address_id'] ?? false)) {
            $attributes['address_id'] = Address::create($attributes['address'])->id;
        }

        unset($attributes['address']);

        return $this->builder()->updateOrCreate($attributes);
    }

    /**
     * @param int|Model $model
     * @param array $attributes
     * @return bool|int
     */
    public function update(int|Model $model, array $attributes = []): bool|int
    {
        if ($attributes['address'] ?? false) {
            $address = Address::findOrFail($model->address_id);
            $address->update($attributes['address']);

            $attributes['address_id'] = $address->id;
            unset($attributes['address']);
        }

        return $model->refresh()->update($attributes);
    }

    /**
     * @param int|Model|Service $model
     * @param bool $force
     * @return bool
     * @throws Throwable
     */
    public function delete(int|Model|Service $model, bool $force = false): bool
    {
        throw_if(
            $model->beneficiaries()->active()->exists(),
            UnauthorizedException::class,
            ["Il existe au moins un bénéficiaire actif associé au service"]
        );

        return parent::delete($model, $force);
    }

    /**
     * @param array $filters
     * @return Arrayable|array
     */
    public function toView(array $filters = []): Arrayable|array
    {
        $paginator = $this->viewableBuilder(Service::query(), $filters)
            ->latest('services.updated_at')
            ->paginate();

        $data = collect($paginator->items())
            ->map(fn (Arrayable $service) => Arr::onlyRecursive(
                $service->toArray(),
                $this->viewableColumns()
            ));

        return new LengthAwarePaginator($data, $paginator->total(), $paginator->perPage());
    }

    /**
     * @param Builder|EloquentBuilder|null $builder
     * @param array $filters
     * @return Builder|EloquentBuilder
     */
    public function viewableBuilder(EloquentBuilder|Builder|null $builder = null, array $filters = []): Builder|EloquentBuilder
    {
        $builder = $builder ?: $this->builder();

        $builder->select('services.*')
            ->with('address')->with('customer')
            ->join('addresses', 'addresses.id', 'address_id')
            ->join('customers', 'customers.id', 'customer_id');

        return $this->orderBy(
            $this->filter($builder, Arr::except($filters, "order-by"), $this->filterRules()),
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
            'code',
            'bo_reference',
            'contact_name',
            'delivery_site',
            'active',

            'customer.id',
            'customer.code',
            'customer.bo_reference',
            'customer.name',
            'customer.contact_name',
            'customer.active',

            'address.id',
            'address.address_1',
            'address.address_2',
            'address.postal_code',
            'address.country',
        ];
    }

    /**
     * @return string[][]
     */
    public function filterRules(): array
    {
        return [
            ['field' => 'active', 'column' => 'services.active', 'operator' => '='],
            ['field' => 'code', 'column' => 'services.code', 'operator' => 'like'],
            ['field' => 'name', 'column' => 'services.name', 'operator' => 'like'],
            ['field' => 'delivery_site', 'column' => 'services.delivery_site', 'operator' => 'like'],
            ['field' => 'bo_reference', 'column' => 'services.bo_reference', 'operator' => 'like'],
            ['field' => 'customer.name', 'column' => 'customers.name', 'operator' => 'like'],
        ];
    }

    /**
     * @param string|null $orderBy
     * @return string[][]
     */
    public function orderByRules(?string $orderBy = null): array
    {
        return [
            ['field' => 'id', 'column' => 'services.id'],
            ['field' => 'active', 'column' => 'services.active'],
            ['field' => 'code', 'column' => 'services.code'],
        ];
    }
}
