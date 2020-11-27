<?php

declare(strict_types=1);

namespace Oqq\Pact\Definition;

use Oqq\Pact\Util\Assert;

final class Headers
{
    /** @var array<string, Header> */
    private array $headers;

    public static function fromArray(array $payload): self
    {
        Assert::isMap($payload);
        Assert::allIsArray($payload);

        $headers = \array_map(
            static fn (array $header): Header => Header::fromArray($header),
            $payload
        );

        return new self($headers);
    }

    public function toArray(): array
    {
        return \array_map(
            static fn (Header $header): array => $header->toArray(),
            $this->headers
        );
    }

    /**
     * @param array<string, Header> $headers
     */
    private function __construct(array $headers)
    {
        $this->headers = $headers;
    }
}
