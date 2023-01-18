<?php

namespace App\Repository;

use App\Models\Beneficiary;
use App\Models\Customer;
use App\Models\Model as BaseModel;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Repository\Contracts\Interfaces\OrderRepositoryInterface;
use App\Repository\Contracts\Repository;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Throwable;

/**
 * Class OrderRepository
 * @package App\Repository
 */
class OrderRepository extends Repository implements OrderRepositoryInterface
{
    public function create(array $attributes): EloquentBuilder|BaseModel
    {
        if ($attributes['customer_code'] ?? false) {
            $attributes['customer_id'] = Customer::where('code', $attributes['customer_code'])->firstOrFail()->id;
            unset($attributes['customer_code']);
        }

        return parent::create($attributes);
    }

    /**
     * @param int|Order $model
     * @param array $attributes
     * @return bool|int
     */
    public function update(int|Model $model, array $attributes = []): bool|int
    {
        if ($attributes['customer_code'] ?? false) {
            $attributes['customer_id'] = Customer::where('code', $attributes['customer_code'])->firstOrFail()->id;
            unset($attributes['customer_code']);
        }

        return parent::update($model, $attributes);
    }

    /**
     * @param int|Order $model
     * @param false $force
     * @return bool
     */
    public function delete(Model|int $model, bool $force = false): bool
    {
        if (is_int($model)) {
            $model = Order::findOrFail($model);
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

        if (isset($filters['active'])) {
            $filters['active'] = filter_var($filters['active'], FILTER_VALIDATE_BOOLEAN);
        }

        $builder->select("orders.*")->with('customer', 'customer.address');

        return $this->orderBy(
            $this->filter($builder, Arr::except($filters, 'order-by'), $this->filterRules()),
            $this->parseOrderByQueryParam($filters['order-by'] ?? '')
        );
    }

    /**
     * @param array $filters
     * @return Arrayable|array
     */
    public function toView(array $filters = []): Arrayable|array
    {
        $paginator = $this->viewableBuilder(Order::query(), $filters)->paginate();

        $data = collect($paginator->items())
            ->map(fn (Arrayable $order) => Arr::onlyRecursive(
                $order->toArray(),
                $this->viewableColumns()
            ));

        return new LengthAwarePaginator($data, $paginator->total(), $paginator->perPage());
    }

    /**
     * @return string[][]
     */
    public function filterRules(): array
    {
        return [
            ['field' => 'active', 'column' => 'orders.active', 'operator' => '='],
            ['field' => 'code', 'column' => 'orders.code', 'operator' => 'like'],
            ['field' => 'reference', 'column' => 'orders.reference', 'operator' => 'like'],
            ['field' => 'type', 'column' => 'orders.type', 'operator' => 'like'],
            ['field' => 'tracking_number', 'column' => 'orders.tracking_number', 'operator' => 'like'],
            ['field' => 'status', 'column' => 'orders.status', 'operator' => 'like'],
            ['field' => 'validated_at', 'column' => 'orders.validated_at', 'operator' => 'like'],
            ['field' => 'transmitted_at', 'column' => 'orders.transmitted_at', 'operator' => 'like'],
            ['field' => 'produced_at', 'column' => 'orders.produced_at', 'operator' => 'like'],
            ['field' => 'shipped_at', 'column' => 'orders.shipped_at', 'operator' => 'like'],
        ];
    }

    /**
     * @param string|null $orderBy
     * @return string[][]
     */
    public function orderByRules(?string $orderBy = null): array
    {
        return [
            ['field' => 'id', 'column' => 'orders.id'],
            ['field' => 'active', 'column' => 'orders.active'],
            ['field' => 'reference', 'column' => 'orders.reference'],
            ['field' => 'type', 'column' => 'orders.type'],
            ['field' => 'status', 'column' => 'orders.status'],
            ['field' => 'validated_at', 'column' => 'orders.validated_at'],
            ['field' => 'transmitted_at', 'column' => 'orders.transmitted_at'],
            ['field' => 'produced_at', 'column' => 'orders.produced_at'],
            ['field' => 'shipped_at', 'column' => 'orders.shipped_at'],
        ];
    }

    /**
     * @return array
     */
    public function viewableColumns(): array
    {
        return [
            'id',
            'reference',
            'type',
            'tracking_number',
            'status',
            'validated_at',
            'transmitted_at',
            'produced_at',
            'shipped_at',
            'active',

            'customer.id',
            'customer.code',
            'customer.bo_reference',
            'customer.name',
            'customer.contact_name',
            'customer.active',
        ];
    }

    /**
     * @return callable
     */
    public function formater(): callable
    {
        return function (Collection|Arrayable|array $model): array {
            return $model instanceof OrderDetail ?
                Arr::onlyRecursive($model->toArray(), $this->viewableDetailColumns()) :
                parent::formater()($model);
        };
    }

    private function viewableDetailColumns(): array
    {
        return [
            'id',
            'quantity',
            'delivery_type',

            'product.id',
            'product.code',
            'product.name',
            'product.price',
            'product.price_share',

            'beneficiary.id',
            'beneficiary.code',
            'beneficiary.first_name',
            'beneficiary.last_name',
            'beneficiary.email',
            'beneficiary.profile',
            'beneficiary.active',
        ];
    }

    /**
     * @param Order $order
     * @return array
     */
    public function details(Order $order): array
    {
        return $order->details()->with(["product", "beneficiary"])->get()
            ->map(fn (OrderDetail $detail) => $this->formater()($detail))
            ->toArray();
    }

    /**
     * @param Order|null $order
     * @param array $details
     * @return OrderDetail
     * @throws Throwable
     */
    public function createDetail(?Order $order, array $details): OrderDetail
    {
        $product = Product::where("code", $details['product_code'])->firstOrFail();

        /** @var Beneficiary $beneficiary */
        $beneficiary = Beneficiary::where("code", $details['beneficiary_code'])->firstOrFail();

        throw_if(
            !$beneficiary->active,
            UnprocessableEntityHttpException::class,
            'The selected beneficiary is not active'
        );

        $details["beneficiary_id"] = $beneficiary->id;
        $details["product_id"] = $product->id;

        /** @var OrderDetail $detail */
        $detail = $order->details()->create($details);
        $detail->load(['beneficiary', 'product']);

        return $detail;
    }

    /**
     * @param Order|null $order
     * @param OrderDetail $detail
     * @param array $attributes
     * @return bool
     * @throws Throwable
     */
    public function updateDetail(?Order $order, OrderDetail $detail, array $attributes = []): bool
    {
        $product = Product::where('code', $attributes['product_code'])->firstOrFail();

        /** @var Beneficiary $beneficiary */
        $beneficiary = Beneficiary::where('code', $attributes['beneficiary_code'])->firstOrFail();

        throw_if(
            !$beneficiary->active,
            UnprocessableEntityHttpException::class,
            'The selected beneficiary is not active'
        );

        $attributes['beneficiary_id'] = $beneficiary->id;
        $attributes['product_id'] = $product->id;

        $detail->load(['beneficiary', 'product']);

        return $detail->update($attributes);
    }

    /**
     * @param Order $order
     * @param OrderDetail $detail
     */
    public function attachDetail(Order $order, OrderDetail $detail): void
    {
        $detail->update(['order_id' => $order->id]);
    }

    /**
     * @param Order|null $order
     * @param OrderDetail|int $detail
     * @return bool
     */
    public function deleteDetail(?Order $order, OrderDetail|int $detail): bool
    {
        $detail = is_int($detail) ? OrderDetail::findOrFail($detail) : $detail;
        return $detail->delete();
    }

    /**
     * @param Order $order
     * @return Arrayable|array
     */
    public function summary(Order $order): Arrayable|array
    {
        $query = $order->details()->scopes(['activeBeneficiaries', 'notEmpty']);
        $beneficiaries = $query->count();
        $details = $query->get();

        $anonymousChecks = 0;
        $totalChecks = $beneficiaries + $anonymousChecks;

        $quantities = intval($details->sum('quantity'));

        $totalAmount = $details->reduce(fn (int $result, OrderDetail $detail) => $result + ($detail->quantity * $detail->product->price), 0);

        $beneficiariesParts = $details->reduce(fn (int $result, OrderDetail $detail) => $result + ($detail->quantity * $detail->product->price_share), 0);

        return compact("beneficiariesParts", "totalChecks", "beneficiaries", "anonymousChecks", "totalAmount", "quantities");
    }
}
