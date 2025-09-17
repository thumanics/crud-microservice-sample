<?php

namespace App\Domain\User\Contracts;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function findById(int $id): ?User;
    
    public function findByEmail(string $email): ?User;
    
    public function getAll(): Collection;
    
    public function create(array $data): User;
    
    public function update(User $user, array $data): User;
    
    public function delete(User $user): bool;
}