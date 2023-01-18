<?php


namespace App\Models\Tasks;

use App\Models\Contracts\Downloadable;
use App\Models\Task;

class ExportTask extends Task implements Downloadable
{
    public const EXPORT_PENDING = 'EXPORT_PENDING';
    public const EXPORT_QUEUED = 'EXPORT_QUEUED';
    public const EXPORT_PROCESSING = 'EXPORT_PROCESSING';
    public const EXPORT_DONE = 'EXPORT_DONE';
    public const EXPORT_FAILED = 'EXPORT_FAILED';

    /**
     * @return int
     */
    public static function EXPORT_PENDING_ID(): int
    {
        return self::getListingByCode(self::EXPORT_PENDING)->id;
    }

    /**
     * @return int
     */
    public static function EXPORT_QUEUED_ID(): int
    {
        return self::getListingByCode(self::EXPORT_QUEUED)->id;
    }

    /**
     * @return int
     */
    public static function EXPORT_PROCESSING_ID(): int
    {
        return self::getListingByCode(self::EXPORT_PROCESSING)->id;
    }

    /**
     * @return int
     */
    public static function EXPORT_DONE_ID(): int
    {
        return self::getListingByCode(self::EXPORT_DONE)->id;
    }

    /**
     * @return int
     */
    public static function EXPORT_FAILED_ID(): int
    {
        return self::getListingByCode(self::EXPORT_FAILED)->id;
    }

    public function onQueue()
    {
        $this->update([$this->listingKeyName() => self::EXPORT_QUEUED_ID()]);
    }

    /**
     * @return string|null
     */
    public function filePath(): ?string
    {
        return $this->payload['file'] ?: null;
    }

    /**
     * @return bool
     */
    public function isReady(): bool
    {
        return is_string($this->payload['file']);
    }
}
