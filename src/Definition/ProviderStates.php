<?php

declare(strict_types=1);

namespace Oqq\Pact\Definition;

use Oqq\Pact\Util\Assert;

final class ProviderStates
{
    /** @var list<ProviderState> */
    private array $providerStates;

    public static function fromArray(array $payload): self
    {
        Assert::allIsArray($payload);

        $providerStates = \array_map(
            static fn (array $state): ProviderState => ProviderState::fromArray($state),
            $payload
        );

        return new self(...$providerStates);
    }

    public function toArray(): array
    {
        return \array_map(
            static fn (ProviderState $state): array => $state->toArray(),
            $this->providerStates
        );
    }

    private function __construct(ProviderState ...$providerStates)
    {
        $this->providerStates = $providerStates;
    }
}
