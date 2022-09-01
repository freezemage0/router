<?php


namespace Freezemage\Router;

final class ServerRequest
{
    private string $method;
    private string $uri;
    private string $body;
    private array $headers;

    public function __construct(string $method, string $uri, string $body, array $headers)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->body = $body;
        $this->headers = $headers;
    }

    public function getRequestMethod(): string
    {
        return $this->method;
    }

    public function getRequestUri(): string
    {
        return $this->uri;
    }

    /**
     * Sorry, no Stream class :/
     *
     * @return string
     */
    public function getRequestBody(): string
    {
        return $this->body;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getHeader(string $header): array
    {
        foreach ($this->headers as $name => $values) {
            if (strcasecmp($name, $header) === 0) {
                return $values;
            }
        }

        return [];
    }

    public function getHeaderLine(string $header): string
    {
        return implode(';', $this->getHeader($header));
    }
}