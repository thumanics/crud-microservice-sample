<?php

namespace App\Application\Services;

use App\Application\DTOs\CreateUserDTO;
use App\Application\DTOs\UpdateUserDTO;
use App\Application\DTOs\UserDTO;
use App\Domain\User\Aggregates\UserAggregate;
use App\Domain\User\Contracts\UserRepositoryInterface;
use App\Domain\User\Services\UserDomainService;
use App\Domain\User\ValueObjects\UserId;
use Illuminate\Database\Eloquent\Collection;

final class UserApplicationService
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly UserDomainService $userDomainService
    ) {}

    public function createUser(CreateUserDTO $dto): UserDTO
    {
        // Domain validation
        $errors = $this->userDomainService->validateUserForCreation(
            $dto->name,
            $dto->email,
            $dto->password
        );

        if (!empty($errors)) {
            throw new \InvalidArgumentException('Validation failed: ' . json_encode($errors));
        }

        // Create aggregate
        $userAggregate = UserAggregate::create(
            $dto->name,
            $dto->email,
            $dto->password
        );

        // Persist via repository
        $userData = [
            'name' => $userAggregate->getName()->value,
            'email' => $userAggregate->getEmail()->value,
            'password' => $userAggregate->getPassword()->value,
        ];

        $user = $this->userRepository->create($userData);

        // TODO: Publish domain events
        $events = $userAggregate->getDomainEvents();
        // EventDispatcher::dispatch($events);

        return UserDTO::fromEloquentModel($user);
    }

    public function updateUser(UpdateUserDTO $dto): ?UserDTO
    {
        if (!$dto->hasChanges()) {
            $user = $this->userRepository->findById($dto->id);
            return $user ? UserDTO::fromEloquentModel($user) : null;
        }

        // Domain validation
        $errors = $this->userDomainService->validateUserForUpdate(
            $dto->id,
            $dto->name,
            $dto->email,
            $dto->password
        );

        if (!empty($errors)) {
            throw new \InvalidArgumentException('Validation failed: ' . json_encode($errors));
        }

        $user = $this->userRepository->findById($dto->id);
        if (!$user) {
            return null;
        }

        // Create aggregate from existing user
        $userAggregate = UserAggregate::fromPersistence(
            $user->id,
            $user->name,
            $user->email,
            $user->password,
            $user->created_at,
            $user->updated_at
        );

        // Apply changes
        if ($dto->name !== null) {
            $userAggregate->updateName($dto->name);
        }

        if ($dto->email !== null) {
            $userAggregate->updateEmail($dto->email);
        }

        if ($dto->password !== null) {
            $userAggregate->updatePassword($dto->password);
        }

        // Prepare update data
        $updateData = [];
        if ($dto->name !== null) {
            $updateData['name'] = $userAggregate->getName()->value;
        }
        if ($dto->email !== null) {
            $updateData['email'] = $userAggregate->getEmail()->value;
        }
        if ($dto->password !== null) {
            $updateData['password'] = $userAggregate->getPassword()->value;
        }

        // Persist changes
        $updatedUser = $this->userRepository->update($user, $updateData);

        // TODO: Publish domain events
        $events = $userAggregate->getDomainEvents();
        // EventDispatcher::dispatch($events);

        return UserDTO::fromEloquentModel($updatedUser);
    }

    public function getUserById(int $id): ?UserDTO
    {
        $user = $this->userRepository->findById($id);
        return $user ? UserDTO::fromEloquentModel($user) : null;
    }

    public function getAllUsers(): Collection
    {
        return $this->userRepository->getAll();
    }

    public function deleteUser(int $id): bool
    {
        $user = $this->userRepository->findById($id);
        if (!$user) {
            return false;
        }

        // TODO: Record domain event for user deletion
        // $event = new UserDeletedEvent($user->id);
        // EventDispatcher::dispatch($event);

        return $this->userRepository->delete($user);
    }
}