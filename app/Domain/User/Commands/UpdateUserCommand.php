<?php

namespace App\Domain\User\Commands;

use App\Domain\User\Contracts\CommandInterface;

final readonly class UpdateUserCommand implements CommandInterface
{
    public function __construct(
        public int $id,
        public ?string $name = null,
        public ?string $email = null,
        public ?string $password = null
    ) {}
}