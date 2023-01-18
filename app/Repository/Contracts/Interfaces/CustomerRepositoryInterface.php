<?php

namespace App\Repository\Contracts\Interfaces;

use App\Repository\Contracts\CanImport;
use App\Repository\Contracts\Viewable;

interface CustomerRepositoryInterface extends RepositoryInterface, Viewable, CanImport
{
    //
}
