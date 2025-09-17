<?php

namespace App\Application\DTOs;

final readonly class UpdateUserDTO
{
    public function __construct(
        public int $id,
        public ?string $name = null,
        public ?string $email = null,
        public ?string $password = null
    ) {}

    public static function fromRequest(int $id, array $data): self
    {
        return new self(
            id: $id,
            name: $data['name'] ?? null,
            email: $data['email'] ?? null,
            password: $data['password'] ?? null
        );
    }

    public function hasChanges(): bool
    {
        return $this->name !== null || $this->email !== null || $this->password !== null;
    }

    public function toArray(): array
    {
        $result = ['id' => $this->id];
        
        if ($this->name !== null) {
            $result['name'] = $this->name;
        }
        
        if ($this->email !== null) {
            $result['email'] = $this->email;
        }
        
        if ($this->password !== null) {
            $result['password'] = $this->password;
        }
        
        return $result;
    }
}