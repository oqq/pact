<?php

declare(strict_types=1);

namespace Oqq\Pact\Definition;

use Oqq\Pact\Util\Assert;

final class InteractionPact
{
    private Consumer $consumer;
    private Provider $provider;
    private Interactions $interactions;

    public static function fromArray(array $payload): self
    {
        Assert::keyExists($payload, 'consumer');
        Assert::isArray($payload['consumer']);

        Assert::keyExists($payload, 'provider');
        Assert::isArray($payload['provider']);

        Assert::keyExists($payload, 'interactions');
        Assert::isArray($payload['interactions']);

        $consumer = Consumer::fromArray($payload['consumer']);
        $provider = Provider::fromArray($payload['provider']);
        $interactions = Interactions::fromArray($payload['interactions']);

        return new self($consumer, $provider, $interactions);
    }

    public function toArray(): array
    {
        return [
            'consumer' => $this->consumer->toArray(),
            'provider' => $this->provider->toArray(),
            'interactions' => $this->interactions->toArray(),
        ];
    }

    private function __construct(Consumer $consumer, Provider $provider, Interactions $interactions)
    {
        $this->consumer = $consumer;
        $this->provider = $provider;
        $this->interactions = $interactions;
    }
}
