<?php

declare(strict_types=1);

namespace Oqq\Pact\PactBuilder;

use Oqq\Pact\Definition\Message;

final class MessageBuilder
{
    private string $description = '';
    private array $providerStates = [];
    private array $metadata = [];
    private ?JsonPatternBuilder $bodyBuilder = null;

    public function expectsToReceive(string $description): self
    {
        $clone = clone $this;
        $clone->description = $description;

        return $clone;
    }

    public function given(string $name, array $params): self
    {
        $clone = clone $this;
        $clone->providerStates[] = ['name' => $name, 'params' => $params];

        return $clone;
    }

    public function withMetadata(array $metadata): self
    {
        $clone = clone $this;
        $clone->metadata = \array_merge($clone->metadata, $metadata);

        return $clone;
    }

    /**
     * @param callable(JsonPatternBuilder):JsonPatternBuilder $callable
     */
    public function withJsonBody(callable $callable): self
    {
        $clone = $this->withMetadata(['Content-Type' => 'application/json']);
        $clone->bodyBuilder = $callable(new JsonPatternBuilder());

        return $clone;
    }

    public function build(): Message
    {
        $body = $this->bodyBuilder === null
            ? ['content' => '', 'matching_rules' => []]
            : $this->bodyBuilder->build()->toArray();

        return Message::fromArray([
            'description' => $this->description,
            'provider_states' => $this->providerStates,
            'body' => $body,
            'metadata' => $this->metadata,
        ]);
    }
}
