<?php

namespace App\Domain\User\Queries;

use App\Domain\User\Contracts\QueryInterface;

final readonly class ListUsersQuery implements QueryInterface
{
    public function __construct() {}
}