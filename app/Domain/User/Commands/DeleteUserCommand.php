<?php

namespace App\Domain\User\Commands;

use App\Domain\User\Contracts\CommandInterface;

final readonly class DeleteUserCommand implements CommandInterface
{
    public function __construct(
        public int $id
    ) {}
}