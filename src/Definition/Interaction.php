<?php

declare(strict_types=1);

namespace Oqq\Pact\Definition;

use Oqq\Pact\Util\Assert;

final class Interaction
{
    private Description $description;
    private ProviderStates $providerStates;
    private ConsumerRequest $consumerRequest;
    private ProviderResponse $providerResponse;

    public static function fromArray(array $payload): self
    {
        Assert::keyExists($payload, 'description');
        Assert::string($payload['description']);

        Assert::keyExists($payload, 'provider_states');
        Assert::isArray($payload['provider_states']);

        Assert::keyExists($payload, 'consumer_request');
        Assert::isArray($payload['consumer_request']);

        Assert::keyExists($payload, 'provider_response');
        Assert::isArray($payload['provider_response']);

        $description = Description::fromString($payload['description']);
        $providerStates = ProviderStates::fromArray($payload['provider_states']);
        $consumerRequest = ConsumerRequest::fromArray($payload['consumer_request']);
        $providerResponse = ProviderResponse::fromArray($payload['provider_response']);

        return new self($description, $providerStates, $consumerRequest, $providerResponse);
    }

    public function toArray(): array
    {
        return [
            'description' => $this->description->value(),
            'provider_states' => $this->providerStates->toArray(),
            'consumer_request' => $this->consumerRequest->toArray(),
            'provider_response' => $this->providerResponse->toArray(),
        ];
    }

    private function __construct(
        Description $description,
        ProviderStates $providerStates,
        ConsumerRequest $consumerRequest,
        ProviderResponse $providerResponse
    ) {
        $this->description = $description;
        $this->providerStates = $providerStates;
        $this->consumerRequest = $consumerRequest;
        $this->providerResponse = $providerResponse;
    }
}
