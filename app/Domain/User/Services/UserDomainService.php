<?php

namespace App\Domain\User\Services;

use App\Domain\User\Contracts\UserRepositoryInterface;
use App\Domain\User\ValueObjects\Email;

final class UserDomainService
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function isEmailUnique(Email $email, ?int $excludeUserId = null): bool
    {
        $existingUser = $this->userRepository->findByEmail($email->value);
        
        if (!$existingUser) {
            return true;
        }

        // If we're updating a user, allow them to keep their current email
        if ($excludeUserId && $existingUser->id === $excludeUserId) {
            return true;
        }

        return false;
    }

    public function validateUserForCreation(string $name, string $email, string $password): array
    {
        $errors = [];

        try {
            new \App\Domain\User\ValueObjects\UserName($name);
        } catch (\InvalidArgumentException $e) {
            $errors['name'] = $e->getMessage();
        }

        try {
            $emailVO = new Email($email);
            if (!$this->isEmailUnique($emailVO)) {
                $errors['email'] = 'Email address is already taken';
            }
        } catch (\InvalidArgumentException $e) {
            $errors['email'] = $e->getMessage();
        }

        try {
            \App\Domain\User\ValueObjects\HashedPassword::fromPlainText($password);
        } catch (\InvalidArgumentException $e) {
            $errors['password'] = $e->getMessage();
        }

        return $errors;
    }

    public function validateUserForUpdate(int $userId, ?string $name = null, ?string $email = null, ?string $password = null): array
    {
        $errors = [];

        if ($name !== null) {
            try {
                new \App\Domain\User\ValueObjects\UserName($name);
            } catch (\InvalidArgumentException $e) {
                $errors['name'] = $e->getMessage();
            }
        }

        if ($email !== null) {
            try {
                $emailVO = new Email($email);
                if (!$this->isEmailUnique($emailVO, $userId)) {
                    $errors['email'] = 'Email address is already taken';
                }
            } catch (\InvalidArgumentException $e) {
                $errors['email'] = $e->getMessage();
            }
        }

        if ($password !== null) {
            try {
                \App\Domain\User\ValueObjects\HashedPassword::fromPlainText($password);
            } catch (\InvalidArgumentException $e) {
                $errors['password'] = $e->getMessage();
            }
        }

        return $errors;
    }
}