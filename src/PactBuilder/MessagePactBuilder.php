<?php

declare(strict_types=1);

namespace Oqq\Pact\PactBuilder;

use Oqq\Pact\Definition\MessagePact;

final class MessagePactBuilder
{
    private string $consumer = '';
    private string $provider = '';

    /** @var list<MessageBuilder> */
    private array $messageBuilders = [];

    public function consumer(string $consumer): self
    {
        $clone = clone $this;
        $clone->consumer = $consumer;

        return $clone;
    }

    public function hasPactWith(string $provider): self
    {
        $clone = clone $this;
        $clone->provider = $provider;

        return $clone;
    }

    /**
     * @param callable(MessageBuilder):MessageBuilder $callable
     */
    public function withMessage(callable $callable): self
    {
        $clone = clone $this;
        $clone->messageBuilders[] = $callable(new MessageBuilder());

        return $clone;
    }

    public function build(): MessagePact
    {
        return MessagePact::fromArray([
            'consumer' => [
                'name' => $this->consumer,
            ],
            'provider' => [
                'name' => $this->provider,
            ],
            'messages' => \array_map(
                static fn(MessageBuilder $messageBuilder): array => $messageBuilder->build()->toArray(),
                $this->messageBuilders
            ),
        ]);
    }
}
