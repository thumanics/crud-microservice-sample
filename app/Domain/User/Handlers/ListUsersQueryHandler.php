<?php

namespace App\Domain\User\Handlers;

use App\Domain\User\Queries\ListUsersQuery;
use App\Domain\User\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

final class ListUsersQueryHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function __invoke(ListUsersQuery $query): Collection
    {
        return $this->userRepository->getAll();
    }
}