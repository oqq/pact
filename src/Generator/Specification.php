<?php

declare(strict_types=1);

namespace Oqq\Pact\Generator;

use Oqq\Pact\Util\Assert;

final class Specification
{
    private string $version;

    public static function fromArray(array $payload): self
    {
        Assert::keyExists($payload, 'version');
        Assert::string($payload['version']);

        return new self($payload['version']);
    }

    public function toArray(): array
    {
        return [
            'version' => $this->version,
        ];
    }

    public function version(): string
    {
        return $this->version;
    }

    private function __construct(string $version)
    {
        $this->version = $version;
    }
}
