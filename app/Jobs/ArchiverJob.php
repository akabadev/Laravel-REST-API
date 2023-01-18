<?php


namespace App\Jobs;

use App\Archivers\OrdersArchiver;
use App\Models\Order;
use App\Models\Task;
use App\Models\Tenant;
use Exception;

class ArchiverJob extends Job
{
    protected function __construct(Tenant $tenant, Task $task, private ?Order $order)
    {
        parent::__construct($tenant, $task);
    }

    /**
     * @param Task $task
     * @return static
     */
    public static function instance(Task $task): static
    {
        /** @var Order $order */
        $order = Order::find($task->payload['order']);
        return new static(tenant(), $task, $order);
    }

    /**
     * @throws Exception
     */
    protected function handleOnTenancyContext(): void
    {
        $ids = $this->order ? [$this->order->id] : [];
        $archiver = new OrdersArchiver($this->tenant);
        $archiver->archive($ids);
        $this->task->succeeded();
    }

    protected function handleOnCentralContext(): void
    {
        //
    }
}
