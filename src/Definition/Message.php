<?php

declare(strict_types=1);

namespace Oqq\Pact\Definition;

use Oqq\Pact\Util\Assert;

final class Message
{
    private Description $description;
    private ProviderStates $providerStates;
    private Body $body;
    private array $metadata;

    public static function fromArray(array $payload): self
    {
        Assert::keyExists($payload, 'description');
        Assert::string($payload['description']);

        Assert::keyExists($payload, 'provider_states');
        Assert::isArray($payload['provider_states']);

        Assert::keyExists($payload, 'body');
        Assert::isArray($payload['body']);

        Assert::keyExists($payload, 'metadata');
        Assert::isMap($payload['metadata']);

        $description = Description::fromString($payload['description']);
        $providerStates = ProviderStates::fromArray($payload['provider_states']);
        $body = Body::fromArray($payload['body']);

        return new self($description, $providerStates, $body, $payload['metadata']);
    }

    public function toArray(): array
    {
        return [
            'description' => $this->description->value(),
            'provider_states' => $this->providerStates->toArray(),
            'body' => $this->body->toArray(),
            'metadata' => $this->metadata,
        ];
    }

    public function description(): Description
    {
        return $this->description;
    }

    public function body(): Body
    {
        return $this->body;
    }

    public function metadata(): array
    {
        return $this->metadata;
    }

    private function __construct(
        Description $description,
        ProviderStates $providerStates,
        Body $body,
        array $metadata
    ) {
        $this->description = $description;
        $this->providerStates = $providerStates;
        $this->body = $body;
        $this->metadata = $metadata;
    }
}
