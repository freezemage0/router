<?php


namespace Freezemage\Router;

final class RoutingResult
{
    public const FOUND = 0;
    public const NOT_FOUND = 1;
    public const METHOD_NOT_ALLOWED = 2;

    private int $result;
    private ?Route $route;

    public function __construct(int $result, ?Route $route)
    {
        $this->result = $result;
        $this->route = $route;
    }

    public function getResult(): int
    {
        return $this->result;
    }

    public function getRoute(): ?Route
    {
        return $this->route;
    }
}