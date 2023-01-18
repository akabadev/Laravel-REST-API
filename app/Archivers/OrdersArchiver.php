<?php

namespace App\Archivers;

use App\Models\OrderDetail;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\LazyCollection;

class OrdersArchiver extends Archiver
{
    /**
     * @param array $ids
     * @return EloquentBuilder|QueryBuilder|LazyCollection
     */
    protected function build(array $ids = []): EloquentBuilder|QueryBuilder|LazyCollection
    {
        return OrderDetail::query()->when($ids, function (EloquentBuilder|QueryBuilder $builder) use ($ids) {
            $builder->findMany($ids);
        })->with([
            'order',
            'order.customer',
            'beneficiary',
            'beneficiary.address',
            'beneficiary.service',
            'product'
        ]);
    }

    /**
     * @return array
     */
    protected function sourceToDestinationColumnsAssociations(): array
    {
        return [
            // OrderDetail
            'quantity' => [
                'column' => 'quantity',
                'indexed' => false
            ],
            'delivery_type' => [
                'column' => 'delivery_type',
                'indexed' => false
            ],

            // OrderDetail => Beneficiary
            'beneficiary.code' => [
                'column' => 'beneficiary_code',
                'indexed' => true
            ],
            'beneficiary.first_name' => [
                'column' => 'beneficiary_first_name',
                'indexed' => true
            ],
            'beneficiary.last_name' => [
                'column' => 'beneficiary_last_name',
                'indexed' => false
            ],
            'beneficiary.email' => [
                'column' => 'beneficiary_email',
                'indexed' => false
            ],
            'beneficiary.profile' => [
                'column' => 'beneficiary_profile',
                'indexed' => false
            ],
            'beneficiary.active' => [
                'column' => 'beneficiary_active',
                'indexed' => false
            ],

            // OrderDetail => Beneficiary => Address
            'beneficiary.address.address_1' => [
                'column' => 'beneficiary_address_address_1',
                'indexed' => false
            ],
            'beneficiary.address.address_2' => [
                'column' => 'beneficiary_address_address_2',
                'indexed' => false
            ],
            'beneficiary.address.postal_code' => [
                'column' => 'beneficiary_address_postal_code',
                'indexed' => false
            ],
            'beneficiary.address.town' => [
                'column' => 'beneficiary_address_town',
                'indexed' => false
            ],
            'beneficiary.address.country' => [
                'column' => 'beneficiary_address_country',
                'indexed' => false
            ],

            // OrderDetail => Beneficiary => Service
            'beneficiary.service.code' => [
                'column' => 'beneficiary_service_code',
                'indexed' => true
            ],
            'beneficiary.service.bo_reference' => [
                'column' => 'beneficiary_service_bo_reference',
                'indexed' => false
            ],
            'beneficiary.service.customer_id' => [
                'column' => 'beneficiary_service_customer_id',
                'indexed' => false
            ],
            'beneficiary.service.name' => [
                'column' => 'beneficiary_service_name',
                'indexed' => true
            ],
            'beneficiary.service.contact_name' => [
                'column' => 'beneficiary_service_contact_name',
                'indexed' => false
            ],
            'beneficiary.service.address_id' => [
                'column' => 'beneficiary_service_address_id',
                'indexed' => false
            ],
            'beneficiary.service.delivery_site' => [
                'column' => 'beneficiary_service_delivery_site',
                'indexed' => false
            ],
            'beneficiary.service.active' => [
                'column' => 'beneficiary_service_active',
                'indexed' => false
            ],

            // OrderDetail => Product
            'product.code' => [
                'column' => 'product_code',
                'indexed' => true
            ],
            'product.name' => [
                'column' => 'product_name',
                'indexed' => true
            ],
            'product.price' => [
                'column' => 'product_price',
                'indexed' => false
            ],
            'product.price_share' => [
                'column' => 'product_price_share',
                'indexed' => false
            ],

            // OrderDetail => Order
            'order.tracking_number' => [
                'column' => 'order_tracking_number',
                'indexed' => false
            ],
            'order.status' => [
                'column' => 'order_status',
                'indexed' => false
            ],
            'order.validated_at' => [
                'column' => 'order_validated_at',
                'indexed' => false
            ],
            'order.generated_at' => [
                'column' => 'order_generated_at',
                'indexed' => false
            ],
            'order.transmitted_at' => [
                'column' => 'order_transmitted_at',
                'indexed' => false
            ],
            'order.produced_at' => [
                'column' => 'order_produced_at',
                'indexed' => false
            ],
            'order.shipped_at' => [
                'column' => 'order_shipped_at',
                'indexed' => false
            ],
            'order.reference' => [
                'column' => 'order_reference',
                'indexed' => false
            ],
            'order.type' => [
                'column' => 'order_type',
                'indexed' => false
            ],

            // OrderDetail => Order => Customer
            "order.customer.code" => [
                'column' => "order_customer_code",
                'indexed' => true
            ],
            "order.customer.bo_reference" => [
                'column' => "order_customer_bo_reference",
                'indexed' => false
            ],
            "order.customer.name" => [
                'column' => "order_customer_name",
                'indexed' => false
            ],
            "order.customer.contact_name" => [
                'column' => "order_customer_contact_name",
                'indexed' => false
            ],
            "order.customer.active" => [
                'column' => "order_customer_active",
                'indexed' => false
            ],
        ];
    }
}
