<?php

namespace App\Repository;

use App\Models\Address;
use App\Models\Beneficiary;
use App\Models\Model as BaseModel;
use App\Models\Service;
use App\Repository\Contracts\Interfaces\BeneficiaryRepositoryInterface;
use App\Repository\Contracts\Repository;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

/**
 * Class BeneficiaryRepository
 * @package App\Repository
 */
class BeneficiaryRepository extends Repository implements BeneficiaryRepositoryInterface
{
    public function create(array $attributes): EloquentBuilder|BaseModel
    {
        $attributes['service_id'] = Service::where('code', $attributes['service_code'] ?? "")->firstOrFail()->id;
        unset($attributes['service_code']);

        on_param('beneficiary.address', function () use ($attributes) {
            if (!($attributes['address_id'] ?? false)) {
                $attributes['address_id'] = Address::create($attributes['address'])->id;
            }
            unset($attributes['address']);
        });

        return $this->builder()->updateOrCreate($attributes);
    }

    /**
     * @param int|Beneficiary $model
     * @param array $attributes
     * @return bool|int
     */
    public function update(int|Model $model, array $attributes = []): bool|int
    {
        if (is_int($model)) {
            $model = Beneficiary::findOrFail($model);
        }

        on_param("beneficiary.address", function () use (&$model, &$attributes) {
            if (($attributes['address'] ?? false)) {
                $model->address()->update($attributes['address']);
                unset($attributes['address']);
            }
        });

        return $model->update($attributes);
    }

    /**
     * @param int|Beneficiary $model
     * @param false $force
     * @return bool
     */
    public function delete(Model|int $model, bool $force = false): bool
    {
        if (is_int($model)) {
            $model = Beneficiary::findOrFail($model);
        }

        return parent::delete($model, $force);
    }

    /**
     * @param Builder|EloquentBuilder|null $builder
     * @param array $filters
     * @return Builder|EloquentBuilder
     */
    public function viewableBuilder(Builder|EloquentBuilder|null $builder = null, array $filters = []): Builder|EloquentBuilder
    {
        $builder = $builder ?: $this->builder();

        if ($filters['active'] ?? false) {
            $filters['active'] = !!in_array(strtolower($filters['active']), ['1', 'true']);
        }

        $builder
            ->select("beneficiaries.*")
            ->with(['service', 'service.customer'])
            ->join('services', 'services.id', 'service_id')
            ->when(param('beneficiary.address'), function (EloquentBuilder $builder) {
                $builder
                    ->with("address")
                    ->leftJoin('addresses', 'addresses.id', 'beneficiaries.address_id');
            });

        return $this->orderBy(
            $this->filter($builder, $filters, $this->filterRules()),
            $this->parseOrderByQueryParam($filters['order-by'] ?? "")
        );
    }

    /**
     * @param array $filters
     * @return Arrayable|array
     */
    public function toView(array $filters = []): Arrayable|array
    {
        $paginator = $this->viewableBuilder(Beneficiary::query(), $filters)->paginate();

        $data = collect($paginator->items())->map(function (Arrayable $beneficiary) {
            return Arr::onlyRecursive($beneficiary->toArray(), $this->viewableColumns());
        });

        return new LengthAwarePaginator($data, $paginator->total(), $paginator->perPage());
    }

    /**
     * @return string[][]
     */
    public function filterRules(): array
    {
        return [
            ['field' => 'active', 'column' => 'beneficiaries.active', 'operator' => '='],
            ['field' => 'code', 'column' => 'beneficiaries.code', 'operator' => 'like'],
            ['field' => 'first_name', 'column' => 'beneficiaries.first_name', 'operator' => 'like'],
            ['field' => 'last_name', 'column' => 'beneficiaries.last_name', 'operator' => 'like'],
            ['field' => 'email', 'column' => 'beneficiaries.email', 'operator' => 'like'],
            ['field' => 'service.name', 'column' => 'services.name', 'operator' => 'like'],
            ['field' => 'service.code', 'column' => 'services.code', 'operator' => 'like'],
            ['field' => 'service.bo_reference', 'column' => 'services.bo_reference', 'operator' => 'like'],
            ['field' => 'service.customer.name', 'column' => 'services.customer.name', 'operator' => 'like'],
        ];
    }

    /**
     * @param string|null $orderBy
     * @return string[][]
     */
    public function orderByRules(?string $orderBy = null): array
    {
        return [
            ['field' => 'id', 'column' => 'beneficiaries.id'],
            ['field' => 'active', 'column' => 'beneficiaries.active'],
            ['field' => 'code', 'column' => 'beneficiaries.code'],
            ['field' => 'first_name', 'column' => 'beneficiaries.first_name'],
            ['field' => 'last_name', 'column' => 'beneficiaries.last_name'],
            ['field' => 'email', 'column' => 'beneficiaries.email'],
        ];
    }

    public function viewableColumns(): array
    {
        $columns = [
            'id',
            'code',
            'first_name',
            'last_name',
            'email',
            'profile',
            'active',
            'service.name',
            'service.code',
            'service.bo_reference',
            'service.customer.id',
            'service.customer.name',
        ];

        return array_merge(
            $columns,
            on_param(
                'beneficiary.address',
                ['address.address_1', 'address.address_2', 'address.postal_code', 'address.town', 'address.country'],
                []
            )
        );
    }
}
