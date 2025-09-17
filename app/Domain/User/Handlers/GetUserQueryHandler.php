<?php

namespace App\Domain\User\Handlers;

use App\Domain\User\Queries\GetUserQuery;
use App\Domain\User\Contracts\UserRepositoryInterface;
use App\Models\User;

final class GetUserQueryHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function __invoke(GetUserQuery $query): ?User
    {
        return $this->userRepository->findById($query->id);
    }
}