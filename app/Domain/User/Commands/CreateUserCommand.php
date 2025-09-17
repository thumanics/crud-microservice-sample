<?php

namespace App\Domain\User\Commands;

use App\Domain\User\Contracts\CommandInterface;

final readonly class CreateUserCommand implements CommandInterface
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password
    ) {}
}