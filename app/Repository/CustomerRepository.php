<?php

namespace App\Repository;

use App\Contracts\IO\Import\Pipes\AssociateDataToRuleFields;
use App\Contracts\IO\Import\Pipes\CsvParser;
use App\Contracts\IO\Import\Pipes\ValidateData;
use App\Models\Address;
use App\Models\Beneficiary;
use App\Models\Customer;
use App\Models\ImportProcessing;
use App\Models\Model as BaseModel;
use App\Models\Service;
use App\Models\Task;
use App\Repository\Contracts\Interfaces\CustomerRepositoryInterface;
use App\Repository\Contracts\Repository;
use Exception;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Arr;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Throwable;

/**
 * Class CustomerRepository
 * @package App\Repository
 */
class CustomerRepository extends Repository implements CustomerRepositoryInterface
{
    /**
     * @param array $attributes
     * @return EloquentBuilder|BaseModel
     */
    public function create(array $attributes): EloquentBuilder|BaseModel
    {
        if (!($attributes['address_id'] ?? false)) {
            $attributes['address_id'] = Address::create($attributes['address'])->id;
        }

        $attributes['active'] = boolval(filter_var($attributes['active'] ?? true, FILTER_VALIDATE_BOOL));

        unset($attributes['address']);

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
            $model = Customer::findOrFail($model);
        }

        if ($attributes['address'] ?? false) {
            $model->address()->update($attributes['address']);
            unset($attributes['address']);
        }

        return $model->update($attributes);
    }

    /**
     * @param int|BaseModel|Customer $model
     * @param bool $force
     * @return bool
     * @throws Throwable
     */
    public function delete(int|BaseModel|Customer $model, bool $force = false): bool
    {
        throw_if(
            $model->services()->exists(),
            UnauthorizedException::class,
            ['Il existe au moins un service associé à ce client']
        );

        return parent::delete($model, $force);
    }


    /**
     * @param Task $task
     * @param array $tuples
     * @param array $rules
     * @param int $line
     */
    public function import(Task &$task, array $tuples, array $rules = [], int $line = 1): void
    {
        /** @var Pipeline $pipeline */
        $pipeline = app(Pipeline::class)->through([
            CsvParser::class,
            new AssociateDataToRuleFields($rules),
            new ValidateData($rules),
        ]);

        collect($tuples)->each(function (string $tuple) use (&$task, &$pipeline, &$line) {
            $importProcess = ImportProcessing::init($task, $line, $tuple);

            try {
                $pipeline->send($tuple)->thenReturn();
            } catch (ValidationException $exception) {
                $importProcess->update([
                    'has_error' => true,
                    'errors' => $exception->errors(),
                    'message' => 'Données non valides'
                ]);
                $task->failed();
            } catch (Exception $exception) {
                $importProcess->update([
                    'has_error' => true,
                    'errors' => ['une erreur est survenue'],
                    'message' => $exception->getMessage()
                ]);
                $task->failed();
                throw $exception;
            }

            $line++;
        });
    }

    /**
     * @param array $filters
     * @return Arrayable|array
     */
    public function toView(array $filters = []): Arrayable|array
    {
        $paginator = $this->viewableBuilder(Customer::query(), $filters)->paginate();

        $data = collect($paginator->items())
            ->map(fn (Arrayable $beneficiary) => Arr::onlyRecursive(
                $beneficiary->toArray(),
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

        if ($filters['active'] ?? false) {
            $filters['active'] = !!in_array(strtolower($filters['active']), ['1', 'true']);
        }

        $builder->select("customers.*")
            ->with('address')
            ->join('addresses', 'addresses.id', 'address_id');

        return $this->orderBy(
            $this->filter($builder, $filters, $this->filterRules()),
            $this->parseOrderByQueryParam($filters['order-by'] ?? '')
        );
    }

    /**
     * @return string[][]
     */
    public function filterRules(): array
    {
        return [
            ['field' => 'active', 'column' => 'customers.active', 'operator' => '='],
            ['field' => 'code', 'column' => 'customers.code', 'operator' => 'like'],
            ['field' => 'name', 'column' => 'customers.name', 'operator' => 'like'],
            ['field' => 'contact_name', 'column' => 'customers.contact_name', 'operator' => 'like'],
            ['field' => 'bo_reference', 'column' => 'customers.bo_reference', 'operator' => 'like']
        ];
    }

    /**
     * @param string|null $orderBy
     * @return string[][]
     */
    public function orderByRules(?string $orderBy = null): array
    {
        return [
            ['field' => 'id', 'column' => 'customers.id'],
            ['field' => 'active', 'column' => 'customers.active'],
            ['field' => 'code', 'column' => 'customers.code'],
            ['field' => 'contact_name', 'column' => 'customers.contact_name'],
            ['field' => 'bo_reference', 'column' => 'customers.bo_reference'],
        ];
    }

    /**
     * @return array
     */
    public function viewableColumns(): array
    {
        return [
            'id',
            'code',
            'bo_reference',
            'name',
            'contact_name',
            'active',
            'address.id',
            'address.address_1',
            'address.address_2',
            'address.postal_code',
            'address.town',
            'address.country',
        ];
    }
}
