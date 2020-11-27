<?php

declare(strict_types=1);

namespace Oqq\Pact\Definition;

use Oqq\Pact\Util\Assert;

final class Consumer
{
    private string $name;

    public static function fromArray(array $payload): self
    {
        Assert::keyExists($payload, 'name');
        Assert::stringNotEmpty($payload['name']);

        return new self($payload['name']);
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
        ];
    }

    private function __construct(string $name)
    {
        $this->name = $name;
    }
}
