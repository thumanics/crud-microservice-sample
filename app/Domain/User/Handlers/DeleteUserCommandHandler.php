<?php

namespace App\Domain\User\Handlers;

use App\Domain\User\Commands\DeleteUserCommand;
use App\Domain\User\Contracts\UserRepositoryInterface;

final class DeleteUserCommandHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function __invoke(DeleteUserCommand $command): bool
    {
        $user = $this->userRepository->findById($command->id);
        
        if (!$user) {
            return false;
        }

        return $this->userRepository->delete($user);
    }
}