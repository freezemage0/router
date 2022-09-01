<?php


namespace Freezemage\Router;

use Closure;


final class Route
{
    private string $pattern;
    private array $arguments;
    private Closure $handler;

    public function __construct(string $pattern, array $arguments, callable $handler)
    {
        $this->pattern = $pattern;
        $this->arguments = $arguments;
        $this->handler = Closure::fromCallable($handler);
    }

    public function getPattern(): string
    {
        return $this->pattern;
    }

    public function getArguments(): array
    {
        return $this->arguments;
    }

    public function setArguments(array $arguments): void
    {
        $this->arguments = $arguments;
    }

    public function getHandler(): Closure
    {
        return $this->handler;
    }

    public function execute(): void
    {
        $this->handler->call($this, ...$this->arguments);
    }
}