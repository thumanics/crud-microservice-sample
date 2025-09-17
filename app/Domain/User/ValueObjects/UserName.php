<?php

namespace App\Domain\User\ValueObjects;

use InvalidArgumentException;

final readonly class UserName
{
    public function __construct(
        public string $value
    ) {
        $this->validate();
    }

    private function validate(): void
    {
        $trimmed = trim($this->value);
        
        if (empty($trimmed)) {
            throw new InvalidArgumentException("Name cannot be empty");
        }

        if (strlen($trimmed) < 2) {
            throw new InvalidArgumentException("Name must be at least 2 characters long");
        }

        if (strlen($trimmed) > 255) {
            throw new InvalidArgumentException("Name is too long. Maximum 255 characters allowed.");
        }

        if (!preg_match('/^[\p{L}\p{M}\s\-\'\.]+$/u', $trimmed)) {
            throw new InvalidArgumentException("Name contains invalid characters");
        }
    }

    public function equals(UserName $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}