<?php

declare(strict_types=1);

namespace Oqq\Pact\Definition;

use Oqq\Pact\Util\Assert;

final class ConsumerRequest
{
    private Method $method;
    private Path $path;
    private Query $query;
    private Headers $headers;
    private Body $body;

    public static function fromArray(array $payload): self
    {
        Assert::keyExists($payload, 'method');
        Assert::string($payload['method']);

        Assert::keyExists($payload, 'path');
        Assert::isArray($payload['path']);

        Assert::keyExists($payload, 'query');
        Assert::isArray($payload['query']);

        Assert::keyExists($payload, 'headers');
        Assert::isArray($payload['headers']);

        Assert::keyExists($payload, 'body');
        Assert::isArray($payload['body']);

        $method = Method::fromString($payload['method']);
        $path = Path::fromArray($payload['path']);
        $query = Query::fromArray($payload['query']);
        $headers = Headers::fromArray($payload['headers']);
        $body = Body::fromArray($payload['body']);

        return new self($method, $path, $query, $headers, $body);
    }

    public function toArray(): array
    {
        return [
            'method' => $this->method->value(),
            'path' => $this->path->toArray(),
            'query' => $this->query->toArray(),
            'headers' => $this->headers->toArray(),
            'body' => $this->body->toArray(),
        ];
    }

    private function __construct(Method $method, Path $path, Query $query, Headers $headers, Body $body)
    {
        $this->method = $method;
        $this->path = $path;
        $this->query = $query;
        $this->headers = $headers;
        $this->body = $body;
    }
}
