<?php

declare(strict_types=1);

namespace Oqq\Pact\Definition;

use Oqq\Pact\Util\Assert;

final class MessagePact
{
    private Consumer $consumer;
    private Provider $provider;
    private Messages $messages;

    public static function fromArray(array $payload): self
    {
        Assert::keyExists($payload, 'consumer');
        Assert::isArray($payload['consumer']);

        Assert::keyExists($payload, 'provider');
        Assert::isArray($payload['provider']);

        Assert::keyExists($payload, 'messages');
        Assert::isArray($payload['messages']);

        $consumer = Consumer::fromArray($payload['consumer']);
        $provider = Provider::fromArray($payload['provider']);
        $messages = Messages::fromArray($payload['messages']);

        return new self($consumer, $provider, $messages);
    }

    public function toArray(): array
    {
        return [
            'consumer' => $this->consumer->toArray(),
            'provider' => $this->provider->toArray(),
            'messages' => $this->messages->toArray(),
        ];
    }

    private function __construct(Consumer $consumer, Provider $provider, Messages $messages)
    {
        $this->consumer = $consumer;
        $this->provider = $provider;
        $this->messages = $messages;
    }
}
