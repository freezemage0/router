<?php


namespace Freezemage\Router;

final class Response
{
    private int $status;
    private string $body;

    public function __construct(int $status, string $body)
    {
        $this->status = $status;
        $this->body = $body;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getBody(): string
    {
        return $this->body;
    }
}