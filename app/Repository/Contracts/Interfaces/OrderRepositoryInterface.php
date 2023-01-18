<?php

namespace App\Repository\Contracts\Interfaces;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Contracts\Support\Arrayable;

interface OrderRepositoryInterface extends RepositoryInterface
{
    /**
     * @param Order $order
     * @return array
     */
    public function details(Order $order): array;

    /**
     * @param Order|null $order
     * @param array $details
     * @return OrderDetail
     */
    public function createDetail(?Order $order, array $details): OrderDetail;

    /**
     * @param Order|null $order
     * @param OrderDetail $detail
     * @param array $attributes
     * @return boolean
     */
    public function updateDetail(?Order $order, OrderDetail $detail, array $attributes = []): bool;

    /**
     * @param Order $order
     * @param OrderDetail $detail
     */
    public function attachDetail(Order $order, OrderDetail $detail): void;

    /**
     * @param Order|null $order
     * @param OrderDetail|int $detail
     * @return boolean
     */
    public function deleteDetail(?Order $order, OrderDetail|int $detail): bool;

    /**
     * Recap de la commande
     * @param Order $order
     * @return Arrayable|array
     */
    public function summary(Order $order): Arrayable|array;
}
