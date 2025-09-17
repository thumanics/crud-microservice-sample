<?php

namespace App\Providers;

use App\Application\Services\UserApplicationService;
use App\Domain\User\Contracts\UserRepositoryInterface;
use App\Domain\User\Services\UserDomainService;
use App\Infrastructure\Bus\CommandBus;
use App\Infrastructure\Bus\QueryBus;
use App\Infrastructure\Repositories\EloquentUserRepository;
use Illuminate\Support\ServiceProvider;

class CQRSServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register Repository
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
        
        // Register Domain Services
        $this->app->singleton(UserDomainService::class);
        
        // Register Application Services
        $this->app->singleton(UserApplicationService::class);
        
        // Register Command and Query Bus
        $this->app->singleton(CommandBus::class);
        $this->app->singleton(QueryBus::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
