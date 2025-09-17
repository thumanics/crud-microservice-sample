<?php

namespace App\Domain\User\ValueObjects;

use InvalidArgumentException;

final readonly class Email
{
    public function __construct(
        public string $value
    ) {
        $this->validate();
    }

    private function validate(): void
    {
        if (!filter_var($this->value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Invalid email format: {$this->value}");
        }

        if (strlen($this->value) > 255) {
            throw new InvalidArgumentException("Email is too long. Maximum 255 characters allowed.");
        }
    }

    public function equals(Email $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}