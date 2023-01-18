<?php

namespace Database\Seeders;

use App\Jobs\ArchiverJob;
use App\Jobs\ExportViewableJob;
use App\Jobs\GenerateOrder;
use App\Jobs\ImportJob;
use App\Models\Process;
use Illuminate\Database\Seeder;

class ProcessesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect($this->data())->each(fn (array $attributes) => Process::create($attributes));
    }

    private function data(): array
    {
        return [
            [
                'code' => ExportViewableJob::class,
                'invokable' => ExportViewableJob::class,
                'description' => 'Exportation'
            ],
            [
                'code' => ImportJob::class,
                'invokable' => ImportJob::class,
                'description' => 'Importation'
            ],
            [
                'code' => GenerateOrder::class,
                'invokable' => GenerateOrder::class,
                'description' => 'Generation des commandes'
            ],
            [
                'code' => ArchiverJob::class,
                'invokable' => ArchiverJob::class,
                'description' => 'Historisation des commandes'
            ]
        ];
    }
}
