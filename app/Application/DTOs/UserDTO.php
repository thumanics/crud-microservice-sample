<?php

namespace App\Application\DTOs;

use Carbon\Carbon;

final readonly class UserDTO
{
    public function __construct(
        public ?int $id,
        public string $name,
        public string $email,
        public ?string $createdAt,
        public ?string $updatedAt
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            name: $data['name'],
            email: $data['email'],
            createdAt: $data['created_at'] ?? null,
            updatedAt: $data['updated_at'] ?? null
        );
    }

    public static function fromEloquentModel($user): self
    {
        return new self(
            id: $user->id,
            name: $user->name,
            email: $user->email,
            createdAt: $user->created_at?->toISOString(),
            updatedAt: $user->updated_at?->toISOString()
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}