<?php

declare(strict_types=1);

namespace Oqq\Pact\PactBuilder;

use Oqq\Pact\Definition\Message;

final class MessageBuilder
{
    private string $description = '';
    private array $providerStates = [];
    private JsonPatternBuilder $metadataBuilder;
    private JsonPatternBuilder $bodyBuilder;

    public function __construct()
    {
        $this->metadataBuilder = new JsonPatternBuilder();
        $this->bodyBuilder = new JsonPatternBuilder();
    }

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

    /**
     * @psalm-type Builder = callable(JsonPatternBuilder):JsonPatternBuilder
     *
     * @param Builder|array $callable
     */
    public function withMetadata(callable|array $callable): self
    {
        $clone = clone $this;

        if (is_array($callable)) {
            $clone->metadataBuilder = $this->metadataBuilder->withPattern($callable);
            return $clone;
        }

        $clone->metadataBuilder = $callable($this->metadataBuilder);

        return $clone;
    }

    /**
     * @param callable(JsonPatternBuilder):JsonPatternBuilder $callable
     */
    public function withJsonBody(callable $callable): self
    {
        $clone = $this->withMetadata(['Content-Type' => 'application/json']);
        $clone->bodyBuilder = $callable($this->bodyBuilder);

        return $clone;
    }

    public function build(): Message
    {
        return Message::fromArray([
            'description' => $this->description,
            'provider_states' => $this->providerStates,
            'body' => $this->bodyBuilder->build()->toArray(),
            'metadata' => $this->metadataBuilder->build()->toArray(),
        ]);
    }
}
