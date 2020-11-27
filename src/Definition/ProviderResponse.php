<?php

declare(strict_types=1);

namespace Oqq\Pact\Definition;

use Oqq\Pact\Util\Assert;

final class ProviderResponse
{
    private Status $status;
    private Headers $headers;
    private Body $body;

    public static function fromArray(array $payload): self
    {
        Assert::keyExists($payload, 'status');
        Assert::integer($payload['status']);

        Assert::keyExists($payload, 'headers');
        Assert::isArray($payload['headers']);

        Assert::keyExists($payload, 'body');
        Assert::isArray($payload['body']);

        $status = Status::fromInteger($payload['status']);
        $headers = Headers::fromArray($payload['headers']);
        $body = Body::fromArray($payload['body']);

        return new self($status, $headers, $body);
    }

    public function toArray(): array
    {
        return [
            'status' => $this->status->value(),
            'headers' => $this->headers->toArray(),
            'body' => $this->body->toArray(),
        ];
    }

    private function __construct(Status $status, Headers $headers, Body $body)
    {
        $this->status = $status;
        $this->headers = $headers;
        $this->body = $body;
    }
}
