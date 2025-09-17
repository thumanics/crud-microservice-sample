<?php

namespace App\Domain\User\Handlers;

use App\Domain\User\Commands\CreateUserCommand;
use App\Domain\User\Contracts\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

final class CreateUserCommandHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function __invoke(CreateUserCommand $command): User
    {
        $userData = [
            'name' => $command->name,
            'email' => $command->email,
            'password' => Hash::make($command->password),
        ];

        return $this->userRepository->create($userData);
    }
}