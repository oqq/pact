<?php

declare(strict_types=1);

namespace Oqq\Pact\Definition;

use Oqq\Pact\Util\Assert;

final class Message
{
    private Description $description;
    private ProviderStates $providerStates;
    private string $content;
    private array $metadata;

    public static function fromArray(array $payload): self
    {
        Assert::keyExists($payload, 'description');
        Assert::string($payload['description']);

        Assert::keyExists($payload, 'provider_states');
        Assert::isArray($payload['provider_states']);

        Assert::keyExists($payload, 'content');
        Assert::string($payload['content']);

        Assert::keyExists($payload, 'metadata');
        Assert::isMap($payload['metadata']);

        $description = Description::fromString($payload['description']);
        $providerStates = ProviderStates::fromArray($payload['provider_states']);

        return new self($description, $providerStates, $payload['content'], $payload['metadata']);
    }

    public function toArray(): array
    {
        return [
            'description' => $this->description->value(),
            'provider_states' => $this->providerStates->toArray(),
            'content' => $this->content,
            'metadata' => $this->metadata,
        ];
    }

    public function content(): string
    {
        return $this->content;
    }

    public function metadata(): array
    {
        return $this->metadata;
    }

    private function __construct(
        Description $description,
        ProviderStates $providerStates,
        string $content,
        array $metadata
    ) {
        $this->description = $description;
        $this->providerStates = $providerStates;
        $this->content = $content;
        $this->metadata = $metadata;
    }
}
