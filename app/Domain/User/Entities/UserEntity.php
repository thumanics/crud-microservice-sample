<?php

namespace App\Domain\User\Entities;

use App\Domain\User\ValueObjects\Email;
use App\Domain\User\ValueObjects\HashedPassword;
use App\Domain\User\ValueObjects\UserId;
use App\Domain\User\ValueObjects\UserName;
use Carbon\Carbon;

final class UserEntity
{
    public function __construct(
        private ?UserId $id,
        private UserName $name,
        private Email $email,
        private HashedPassword $password,
        private ?Carbon $createdAt = null,
        private ?Carbon $updatedAt = null
    ) {}

    public static function create(
        UserName $name,
        Email $email,
        HashedPassword $password
    ): self {
        return new self(
            id: null,
            name: $name,
            email: $email,
            password: $password,
            createdAt: Carbon::now(),
            updatedAt: Carbon::now()
        );
    }

    public static function fromPersistence(
        UserId $id,
        UserName $name,
        Email $email,
        HashedPassword $password,
        Carbon $createdAt,
        Carbon $updatedAt
    ): self {
        return new self(
            id: $id,
            name: $name,
            email: $email,
            password: $password,
            createdAt: $createdAt,
            updatedAt: $updatedAt
        );
    }

    public function getId(): ?UserId
    {
        return $this->id;
    }

    public function getName(): UserName
    {
        return $this->name;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPassword(): HashedPassword
    {
        return $this->password;
    }

    public function getCreatedAt(): ?Carbon
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?Carbon
    {
        return $this->updatedAt;
    }

    public function changeName(UserName $newName): void
    {
        $this->name = $newName;
        $this->updatedAt = Carbon::now();
    }

    public function changeEmail(Email $newEmail): void
    {
        $this->email = $newEmail;
        $this->updatedAt = Carbon::now();
    }

    public function changePassword(HashedPassword $newPassword): void
    {
        $this->password = $newPassword;
        $this->updatedAt = Carbon::now();
    }

    public function verifyPassword(string $plainPassword): bool
    {
        return $this->password->verify($plainPassword);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id?->value,
            'name' => $this->name->value,
            'email' => $this->email->value,
            'created_at' => $this->createdAt?->toISOString(),
            'updated_at' => $this->updatedAt?->toISOString(),
        ];
    }
}