<?php

namespace App\Infrastructure\Bus;

use App\Domain\User\Contracts\CommandInterface;
use Illuminate\Container\Container;

final class CommandBus
{
    public function __construct(
        private readonly Container $container
    ) {}

    public function dispatch(CommandInterface $command): mixed
    {
        $handlerClass = $this->resolveHandlerClass($command);
        $handler = $this->container->make($handlerClass);
        
        return $handler($command);
    }

    private function resolveHandlerClass(CommandInterface $command): string
    {
        $commandClass = get_class($command);
        $commandName = class_basename($commandClass);
        
        return str_replace('Commands', 'Handlers', $commandClass) . 'Handler';
    }
}