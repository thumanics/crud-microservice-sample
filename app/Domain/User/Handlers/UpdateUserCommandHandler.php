<?php

namespace App\Domain\User\Handlers;

use App\Domain\User\Commands\UpdateUserCommand;
use App\Domain\User\Contracts\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

final class UpdateUserCommandHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function __invoke(UpdateUserCommand $command): ?User
    {
        $user = $this->userRepository->findById($command->id);
        
        if (!$user) {
            return null;
        }

        $updateData = [];
        
        if ($command->name !== null) {
            $updateData['name'] = $command->name;
        }
        
        if ($command->email !== null) {
            $updateData['email'] = $command->email;
        }
        
        if ($command->password !== null) {
            $updateData['password'] = Hash::make($command->password);
        }

        if (empty($updateData)) {
            return $user;
        }

        return $this->userRepository->update($user, $updateData);
    }
}