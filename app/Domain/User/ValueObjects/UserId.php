<?php

namespace App\Domain\User\ValueObjects;

use InvalidArgumentException;

final readonly class UserId
{
    public function __construct(
        public int $value
    ) {
        $this->validate();
    }

    private function validate(): void
    {
        if ($this->value <= 0) {
            throw new InvalidArgumentException("User ID must be a positive integer");
        }
    }

    public function equals(UserId $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}