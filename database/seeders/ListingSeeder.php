<?php

namespace Database\Seeders;

use App\Models\Listing;
use App\Models\Product;
use App\Models\Task;
use App\Models\Tasks\ArchiveTask;
use App\Models\Tasks\ExportTask;
use App\Models\Tasks\GenerateOrderTask;
use App\Models\Tasks\ImportTask;
use Illuminate\Database\Seeder;

class ListingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Listing::createMany($this->productTypeListings());
        Listing::createMany($this->exportListings());
        Listing::createMany($this->importListings());
        Listing::createMany($this->orderGenerationListings());
        Listing::createMany($this->archiverListings());
    }

    /**
     * @return array
     */
    private function exportListings(): array
    {
        return [
            [
                'code' => ExportTask::EXPORT_PENDING,
                'description' => '',
                'notion' => Task::class,
            ],
            [
                'code' => ExportTask::EXPORT_QUEUED,
                'description' => '',
                'notion' => Task::class,
            ],
            [
                'code' => ExportTask::EXPORT_PROCESSING,
                'description' => '',
                'notion' => Task::class,
            ],
            [
                'code' => ExportTask::EXPORT_DONE,
                'description' => '',
                'notion' => Task::class,
            ],
            [
                'code' => ExportTask::EXPORT_FAILED,
                'description' => '',
                'notion' => Task::class
            ]
        ];
    }

    /**
     * @return array
     */
    private function importListings(): array
    {
        return [
            [
                'code' => ImportTask::IMPORT_PENDING,
                'description' => 'Importation en attente de traitement',
                'notion' => ImportTask::class,
            ],
            [
                'code' => ImportTask::IMPORT_QUEUED,
                'description' => "Données en file d'attente pour traitement",
                'notion' => ImportTask::class,
            ],
            [
                'code' => ImportTask::IMPORT_PROCESSING,
                'description' => 'Analyse des données en cours...',
                'notion' => ImportTask::class,
            ],
            [
                'code' => ImportTask::IMPORT_DONE,
                'description' => 'Analyse des données terminée avec succès',
                'notion' => ImportTask::class,
            ],
            [
                'code' => ImportTask::IMPORT_FAILED,
                'description' => "L'Analyse des données a échoué",
                'notion' => ImportTask::class,
            ],
            [
                'code' => ImportTask::IMPORT_VALIDATION_PROCESSING,
                'description' => 'Validation des donnée encours',
                'notion' => ImportTask::class,
            ],
            [
                'code' => ImportTask::IMPORT_VALIDATION_DONE,
                'description' => 'Importation terminée avec succès',
                'notion' => ImportTask::class,
            ],
            [
                'code' => ImportTask::IMPORT_VALIDATION_FAILED,
                'description' => 'Échec Importation',
                'notion' => ImportTask::class
            ]
        ];
    }

    /**
     * @return array[][]
     */
    private function productTypeListings(): array
    {
        return [
            [
                'code' => Product::PRODUCT_TYPE_PAPER,
                'description' => 'Produit Papier',
                'notion' => 'PRODUCT_TYPE'
            ],
            [
                'code' => Product::PRODUCT_TYPE_3C,
                'description' => 'Produit 3C',
                'notion' => 'PRODUCT_TYPE'
            ],
            [
                'code' => Product::PRODUCT_TYPE_4C,
                'description' => 'Produit 4C',
                'notion' => 'PRODUCT_TYPE'
            ]
        ];
    }

    private function orderGenerationListings(): array
    {
        return [
            [
                'code' => GenerateOrderTask::GENERATION_PENDING,
                'description' => GenerateOrderTask::getComment(GenerateOrderTask::GENERATION_PENDING),
                'notion' => Task::class,
            ],
            [
                'code' => GenerateOrderTask::GENERATION_QUEUED,
                'description' => GenerateOrderTask::getComment(GenerateOrderTask::GENERATION_QUEUED),
                'notion' => Task::class,
            ],
            [
                'code' => GenerateOrderTask::GENERATION_PROCESSING,
                'description' => GenerateOrderTask::getComment(GenerateOrderTask::GENERATION_PROCESSING),
                'notion' => Task::class,
            ],
            [
                'code' => GenerateOrderTask::GENERATION_DONE,
                'description' => GenerateOrderTask::getComment(GenerateOrderTask::GENERATION_DONE),
                'notion' => Task::class,
            ],
            [
                'code' => GenerateOrderTask::GENERATION_FAILED,
                'description' => GenerateOrderTask::getComment(GenerateOrderTask::GENERATION_FAILED),
                'notion' => Task::class,
            ]
        ];
    }

    private function archiverListings(): array
    {
        return [
            [
                'code' => ArchiveTask::ARCHIVE_PENDING,
                'description' => GenerateOrderTask::getComment(ArchiveTask::ARCHIVE_PENDING),
                'notion' => Task::class,
            ],
            [
                'code' => ArchiveTask::ARCHIVE_QUEUED,
                'description' => ArchiveTask::getComment(ArchiveTask::ARCHIVE_QUEUED),
                'notion' => Task::class,
            ],
            [
                'code' => ArchiveTask::ARCHIVE_PROCESSING,
                'description' => ArchiveTask::getComment(ArchiveTask::ARCHIVE_PROCESSING),
                'notion' => Task::class,
            ],
            [
                'code' => ArchiveTask::ARCHIVE_DONE,
                'description' => ArchiveTask::getComment(ArchiveTask::ARCHIVE_DONE),
                'notion' => Task::class,
            ],
            [
                'code' => ArchiveTask::ARCHIVE_FAILED,
                'description' => ArchiveTask::getComment(ArchiveTask::ARCHIVE_FAILED),
                'notion' => Task::class,
            ]
        ];
    }
}
