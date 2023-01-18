<?php

namespace App\Models\Tasks;

use App\Jobs\ArchiverJob;
use App\Models\Process;
use App\Models\Task;

class ArchiveTask extends Task
{
    public const ARCHIVE_PENDING = 'ARCHIVE_PENDING';
    public const ARCHIVE_QUEUED = 'ARCHIVE_QUEUED';
    public const ARCHIVE_PROCESSING = 'ARCHIVE_PROCESSING';
    public const ARCHIVE_DONE = 'ARCHIVE_DONE';
    public const ARCHIVE_FAILED = 'ARCHIVE_FAILED';

    protected static array $comments = [
        self::ARCHIVE_PENDING => 'Historisation des commandes en attente',
        self::ARCHIVE_QUEUED => "Historisation des commandes en file d'execution",
        self::ARCHIVE_PROCESSING => 'Historisation des commandes en cours...',
        self::ARCHIVE_DONE => 'Historisation des commandes terminée avec succès',
        self::ARCHIVE_FAILED => 'Historisation des commandes terminée avec ECHEC',
    ];

    public static function create(array $fillable = []): Task
    {
        $initial = [
            'process_id' => Process::findOrCreateWithInvokable(ArchiverJob::class, [])->id,
            'status_id' => ArchiveTask::ARCHIVE_PENDING_ID(),
            'payload' => [],
            'available_at' => now(),
            'comment' => 'Historisation des commandes',
        ];

        return parent::create(array_merge_recursive($initial, $fillable));
    }

    /**
     * @return int
     */
    public static function ARCHIVE_PENDING_ID(): int
    {
        return self::getListingByCode(self::ARCHIVE_PENDING)->id;
    }

    /**
     * @return int
     */
    public static function ARCHIVE_QUEUED_ID(): int
    {
        return self::getListingByCode(self::ARCHIVE_QUEUED)->id;
    }

    /**
     * @return int
     */
    public static function ARCHIVE_PROCESSING_ID(): int
    {
        return self::getListingByCode(self::ARCHIVE_PROCESSING)->id;
    }

    /**
     * @return int
     */
    public static function ARCHIVE_DONE_ID(): int
    {
        return self::getListingByCode(self::ARCHIVE_DONE)->id;
    }

    /**
     * @return int
     */
    public static function ARCHIVE_FAILED_ID(): int
    {
        return self::getListingByCode(self::ARCHIVE_FAILED)->id;
    }

    public function onQueue()
    {
        $this->update([$this->listingKeyName() => self::ARCHIVE_QUEUED_ID()]);
    }

    public function start()
    {
        parent::start();
        $this->setListingState(ArchiveTask::ARCHIVE_PROCESSING);
    }


    public function failed()
    {
        parent::failed();
        $this->setListingState(self::ARCHIVE_FAILED);
    }

    public function succeeded()
    {
        parent::succeeded();
        $this->setListingState(self::ARCHIVE_DONE);
    }
}
