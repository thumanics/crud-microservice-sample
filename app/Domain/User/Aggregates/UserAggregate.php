<?php

namespace App\Domain\User\Aggregates;

use App\Domain\User\Entities\UserEntity;
use App\Domain\User\ValueObjects\Email;
use App\Domain\User\ValueObjects\HashedPassword;
use App\Domain\User\ValueObjects\UserId;
use App\Domain\User\ValueObjects\UserName;
use Carbon\Carbon;

final class UserAggregate
{
    private array $domainEvents = [];

    public function __construct(
        private UserEntity $userEntity
    ) {}

    public static function create(
        string $name,
        string $email,
        string $password
    ): self {
        $userEntity = UserEntity::create(
            name: new UserName($name),
            email: new Email($email),
            password: HashedPassword::fromPlainText($password)
        );

        $aggregate = new self($userEntity);
        
        // Record domain event
        $aggregate->recordEvent([
            'type' => 'UserCreated',
            'data' => [
                'name' => $name,
                'email' => $email,
                'timestamp' => Carbon::now()->toISOString()
            ]
        ]);

        return $aggregate;
    }

    public static function fromPersistence(
        int $id,
        string $name,
        string $email,
        string $hashedPassword,
        Carbon $createdAt,
        Carbon $updatedAt
    ): self {
        $userEntity = UserEntity::fromPersistence(
            id: new UserId($id),
            name: new UserName($name),
            email: new Email($email),
            password: HashedPassword::fromHash($hashedPassword),
            createdAt: $createdAt,
            updatedAt: $updatedAt
        );

        return new self($userEntity);
    }

    public function updateName(string $newName): void
    {
        $oldName = $this->userEntity->getName()->value;
        $this->userEntity->changeName(new UserName($newName));
        
        $this->recordEvent([
            'type' => 'UserNameChanged',
            'data' => [
                'user_id' => $this->userEntity->getId()?->value,
                'old_name' => $oldName,
                'new_name' => $newName,
                'timestamp' => Carbon::now()->toISOString()
            ]
        ]);
    }

    public function updateEmail(string $newEmail): void
    {
        $oldEmail = $this->userEntity->getEmail()->value;
        $this->userEntity->changeEmail(new Email($newEmail));
        
        $this->recordEvent([
            'type' => 'UserEmailChanged',
            'data' => [
                'user_id' => $this->userEntity->getId()?->value,
                'old_email' => $oldEmail,
                'new_email' => $newEmail,
                'timestamp' => Carbon::now()->toISOString()
            ]
        ]);
    }

    public function updatePassword(string $newPassword): void
    {
        $this->userEntity->changePassword(HashedPassword::fromPlainText($newPassword));
        
        $this->recordEvent([
            'type' => 'UserPasswordChanged',
            'data' => [
                'user_id' => $this->userEntity->getId()?->value,
                'timestamp' => Carbon::now()->toISOString()
            ]
        ]);
    }

    public function verifyPassword(string $password): bool
    {
        return $this->userEntity->verifyPassword($password);
    }

    public function getUserEntity(): UserEntity
    {
        return $this->userEntity;
    }

    public function getId(): ?UserId
    {
        return $this->userEntity->getId();
    }

    public function getName(): UserName
    {
        return $this->userEntity->getName();
    }

    public function getEmail(): Email
    {
        return $this->userEntity->getEmail();
    }

    public function getPassword(): HashedPassword
    {
        return $this->userEntity->getPassword();
    }

    public function toArray(): array
    {
        return $this->userEntity->toArray();
    }

    public function getDomainEvents(): array
    {
        return $this->domainEvents;
    }

    public function clearDomainEvents(): void
    {
        $this->domainEvents = [];
    }

    private function recordEvent(array $event): void
    {
        $this->domainEvents[] = $event;
    }
}