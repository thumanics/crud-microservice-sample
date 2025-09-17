<?php

namespace App\Infrastructure\Bus;

use App\Domain\User\Contracts\QueryInterface;
use Illuminate\Container\Container;

final class QueryBus
{
    public function __construct(
        private readonly Container $container
    ) {}

    public function dispatch(QueryInterface $query): mixed
    {
        $handlerClass = $this->resolveHandlerClass($query);
        $handler = $this->container->make($handlerClass);
        
        return $handler($query);
    }

    private function resolveHandlerClass(QueryInterface $query): string
    {
        $queryClass = get_class($query);
        $queryName = class_basename($queryClass);
        
        return str_replace('Queries', 'Handlers', $queryClass) . 'Handler';
    }
}