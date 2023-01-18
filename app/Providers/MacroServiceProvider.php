<?php

namespace App\Providers;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Str::macro('pascal', function (string $value) {
            return Str::ucfirst(Str::camel($value));
        });

        Arr::macro('scalarArray', function (array $data) {
            $result = [];
            foreach ($data as $key => $value) {
                if ($value instanceof Arrayable) {
                    $value = Arr::pureArray($value->toArray());
                }
                data_set($result, $key, $value);
            }
            return $result;
        });

        Arr::macro('onlyRecursive', function (array $data, string|array $keys = []) {
            $data = Arr::scalarArray($data);
            $keys = Arr::wrap($keys);
            $result = [];

            foreach ($keys as $key) {
                data_set($result, $key, data_get($data, $key));
            }

            return $result;
        });

        LazyCollection::macro(
            "fromCsv",
            function (string $path, int $chunk = 0, string $separator = ";"): LazyCollection {
                /** @var LazyCollection $collection */
                $collection = static::make(function () use (&$separator, &$path, &$chunk) {
                    $handle = fopen($path, 'r');
                    while ($line = fgetcsv(stream: $handle, separator: $separator)) {
                        yield array_map(fn ($item) => trim($item), $line);
                    }
                });
                return $chunk > 0 ? $collection->chunk($chunk) : $collection;
            }
        );

        LazyCollection::macro(
            'fromFile',
            function (string $path, int $chunk = 0): LazyCollection {
                /** @var LazyCollection $collection */
                $collection = static::make(function () use (&$path) {
                    $handle = fopen($path, 'r');
                    while ($line = fgets($handle)) {
                        yield $line;
                    }
                });
                return $chunk > 0 ? $collection->chunk($chunk) : $collection;
            }
        );
    }
}
