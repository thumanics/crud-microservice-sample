<?php

namespace App\Domain\User\ValueObjects;

use InvalidArgumentException;
use Illuminate\Support\Facades\Hash;

final readonly class HashedPassword
{
    public function __construct(
        public string $value
    ) {
        $this->validate();
    }

    public static function fromPlainText(string $plainPassword): self
    {
        if (strlen($plainPassword) < 8) {
            throw new InvalidArgumentException("Password must be at least 8 characters long");
        }

        if (strlen($plainPassword) > 255) {
            throw new InvalidArgumentException("Password is too long. Maximum 255 characters allowed.");
        }

        return new self(Hash::make($plainPassword));
    }

    public static function fromHash(string $hashedPassword): self
    {
        return new self($hashedPassword);
    }

    private function validate(): void
    {
        if (empty($this->value)) {
            throw new InvalidArgumentException("Hashed password cannot be empty");
        }
    }

    public function verify(string $plainPassword): bool
    {
        return Hash::check($plainPassword, $this->value);
    }

    public function equals(HashedPassword $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}