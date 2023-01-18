<?php

namespace App\Models\Contracts;

use App\Repository\Contracts\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder;

interface CanBeValidated
{
    public function validate(RepositoryInterface|Builder|EloquentBuilder $repository): mixed;

    public function isValidable(): bool;
}
