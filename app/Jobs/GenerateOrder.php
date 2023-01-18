<?php

namespace App\Jobs;

use App\Models\File;
use App\Models\Format;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Pattern;
use App\Models\Task;
use App\Models\Tasks\ArchiveTask;
use App\Models\Tenant;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class GenerateOrder extends Job
{
    protected function __construct(Tenant $tenant, Task $task, private Order $order)
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
        $order = Order::findOrFail($task->payload['order']);
        return new static(tenant(), $task, $order);
    }

    protected function handleOnTenancyContext(): void
    {
        $format = Format::where('code', Order::EXPORT_CODE_FIXED_SIZE)->firstOrFail();
        $columns = client_config($format->config_file, 'columns');
        $viewables = collect($columns)->map(fn ($tuple) => $tuple['column'])->filter()->values()->toArray();

        $file = File::createWithMorph($this->order, Pattern::findByCode("LOGIDOM_V1"));
        $writable = $file->getWritable();

        $line = 0;
        $this->order->details()->scopes(["activeBeneficiaries"])->lazy(10)
            ->each(function (OrderDetail $detail) use (&$writable, &$columns, &$viewables, &$line) {
                $line++;
                $detail->load(['order.customer', 'beneficiary.service', 'product']);
                $data = $detail->toArray();
                $data = data_set($data, "line", $line);
                $content = $this->adapter(Arr::onlyRecursive($data, $viewables), $columns);
                $writable->writeLine($content);
            });

        $writable->close();

        $this->order->tapDateTime("generated_at");
        $this->task->succeeded();

        ArchiveTask::create(["payload" => ["order" => $this->order->id]])->queue();
    }

    /**
     * @param array $data
     * @param array $columns
     * @return string
     */
    private function adapter(array $data, array $columns = []): string
    {
        return collect($columns)->reduce(function ($result, $record) use (&$data) {
            $pad = $record['type'] == 'string' ? " " : "0";
            $direction = $record['type'] == 'string' ? STR_PAD_RIGHT : STR_PAD_LEFT;
            $size = intval($record['size']);
            $value = Str::limit(data_get($data, $record['column'] ?? '', $record['value']), $size, '');
            return $result . str_pad($value, $size, $pad, $direction);
        });
    }

    protected function handleOnCentralContext(): void
    {
        //
    }
}
