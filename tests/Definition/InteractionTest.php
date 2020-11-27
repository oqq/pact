<?php

declare(strict_types=1);

namespace Oqq\PactTest\Definition;

use Oqq\Pact\Definition\Interaction;
use Oqq\PactTest\ValueObjectPayloadAssertion;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Oqq\Pact\Definition\Interaction
 */
final class InteractionTest extends TestCase
{
    public function testItWillCreateFromPerfectPayload(): void
    {
        $consumer = Interaction::fromArray([
            'description' => PayloadExample::description(),
            'provider_states' => PayloadExample::providerStates(),
            'consumer_request' => PayloadExample::consumerRequest(),
            'provider_response' => PayloadExample::providerResponse(),
        ]);

        $payload = $consumer->toArray();

        Assert::assertArrayHasKey('description', $payload);
        Assert::assertArrayHasKey('provider_states', $payload);
        Assert::assertArrayHasKey('consumer_request', $payload);
        Assert::assertArrayHasKey('provider_response', $payload);
    }

    /**
     * @dataProvider invalidPayloadProvider
     */
    public function testItWillThrowWithInvalidPayload(\Exception $expectedException, array $payloadExample): void
    {
        $this->expectExceptionObject($expectedException);

        Interaction::fromArray($payloadExample);
    }

    /**
     * @return iterable<array-key, array{0: \Exception, 1: array}>
     */
    public function invalidPayloadProvider(): iterable
    {
        $perfectValues = [
            'description' => PayloadExample::description(),
            'provider_states' => PayloadExample::providerStates(),
            'consumer_request' => PayloadExample::consumerRequest(),
            'provider_response' => PayloadExample::providerResponse(),
        ];

        yield from ValueObjectPayloadAssertion::string($perfectValues, 'description');
        yield from ValueObjectPayloadAssertion::array($perfectValues, 'provider_states');
        yield from ValueObjectPayloadAssertion::array($perfectValues, 'consumer_request');
        yield from ValueObjectPayloadAssertion::array($perfectValues, 'provider_response');
    }
}
