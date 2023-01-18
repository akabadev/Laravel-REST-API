<?php

namespace App\Models\Tasks;

use App\Models\Task;

class GenerateOrderTask extends Task
{
    public const GENERATION_PENDING = 'GENERATION_PENDING';
    public const GENERATION_QUEUED = 'GENERATION_QUEUED';
    public const GENERATION_PROCESSING = 'GENERATION_PROCESSING';
    public const GENERATION_DONE = 'GENERATION_DONE';
    public const GENERATION_FAILED = 'GENERATION_FAILED';

    protected static array $comments = [
        self::GENERATION_PENDING => "Generation de la commande en attente",
        self::GENERATION_QUEUED => "Generation de la commande est sur la file d'execution",
        self::GENERATION_PROCESSING => "Generation de la commande en cours...",
        self::GENERATION_DONE => "Generation de la commande terminée avec succès",
        self::GENERATION_FAILED => "Generation de la commande terminée avec ECHEC",
    ];

    public function failed()
    {
        parent::failed();
        $this->setListingState(self::GENERATION_FAILED);
    }

    public function succeeded()
    {
        parent::succeeded();
        $this->setListingState(self::GENERATION_DONE);
    }

    public function start()
    {
        parent::start();
        $this->setListingState(self::GENERATION_PROCESSING);
    }
}
