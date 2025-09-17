<?php

namespace App\Domain\User\Queries;

use App\Domain\User\Contracts\QueryInterface;

final readonly class GetUserQuery implements QueryInterface
{
    public function __construct(
        public int $id
    ) {}
}