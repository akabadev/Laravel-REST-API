<?php

namespace App\Archivers;

use App\Models\Tenant;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Str;

abstract class Archiver extends Migration
{
    public function __construct(private ?Tenant $tenant = null)
    {
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    protected function migrate($dropIfExists = false)
    {
        if ($dropIfExists) {
            Schema::dropIfExists($this->tableName());
        }

        $callback = fn (Blueprint $table) => $this->creator($table);

        if (Schema::hasTable($this->tableName())) {
            Schema::table($this->tableName(), $callback);
        } else {
            Schema::create($this->tableName(), $callback);
        }
    }

    final public function archive(array $ids = [])
    {
        $context = $this->tenant && $this->tenant->exists ? Arr::wrap($this->tenant) : null;

        tenancy()->runForMultiple($context, function () use ($ids) {
            $this->migrate();
            $this->seed($ids);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    final protected function down()
    {
        Schema::dropIfExists($this->tableName());
    }

    /**
     * @param Blueprint $table
     * @return void
     */
    protected function creator(Blueprint $table): void
    {
        collect($this->sourceToDestinationColumnsAssociations())->values()->each(function ($tuple) use ($table) {
            if (!Schema::hasColumn($this->tableName(), $tuple['column'])) {
                $definition = $table->string($tuple['column'])->nullable();
                if ($tuple['indexed'] ?? false) {
                    $definition->index($tuple['column'] . '_index');
                }
            }
        });
    }

    /**
     * @param string|null $suffix
     * @return string
     */
    public function tableName(?string $suffix = null): string
    {
        $suffix = Str::snake($suffix ?: now()->year);
        $guessedTable = Str::snake(Str::beforeLast(class_basename($this::class), class_basename(self::class)));
        return 'archive_' . $guessedTable . '_' . $suffix;
    }

    /**
     * @return array
     */
    abstract protected function sourceToDestinationColumnsAssociations(): array;

    /**
     * @param int[] $ids
     * @return EloquentBuilder|QueryBuilder|LazyCollection
     */
    abstract protected function build(array $ids = []): EloquentBuilder|QueryBuilder|LazyCollection;

    public function dropIfExists(): static
    {
        $this->migrate(true);
        return $this;
    }

    /**
     * @param array $ids
     */
    public function seed(array $ids = []): void
    {
        $builder = $this->build($ids);

        ($builder instanceof LazyCollection ? $builder : $builder->lazy())
            ->each(function (Arrayable $data) {
                $associations = $this->sourceToDestinationColumnsAssociations();
                $sourceColumn = array_keys($associations);

                $data = Arr::onlyRecursive($data->toArray(), $sourceColumn);

                $record = [];

                foreach ($sourceColumn as $tuple) {
                    $record[$associations[$tuple]['column']] = data_get($data, $tuple);
                }

                DB::table($this->tableName())->insertOrIgnore($record);
            });
    }
}
