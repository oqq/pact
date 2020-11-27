<?php

declare(strict_types=1);

namespace Oqq\Pact\Definition;

use Oqq\Pact\Util\Assert;

final class ProviderState
{
    private string $name;

    /** @var array<string, mixed> */
    private array $params;

    public static function fromArray(array $payload): self
    {
        Assert::keyExists($payload, 'name');
        Assert::stringNotEmpty($payload['name']);

        Assert::keyExists($payload, 'params');
        Assert::isMap($payload['params']);

        return new self($payload['name'], $payload['params']);
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'params' => $this->params,
        ];
    }

    /**
     * @param array<string, mixed> $params
     */
    private function __construct(string $name, array $params)
    {
        $this->name = $name;
        $this->params = $params;
    }
}
