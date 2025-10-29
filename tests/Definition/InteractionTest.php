<?php

declare(strict_types=1);

namespace Oqq\PactTest\Definition;

use Oqq\Pact\Definition\Interaction;
use Oqq\PactTest\ValueObjectPayloadAssertion;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(\Oqq\Pact\Definition\Interaction::class)]
final class InteractionTest extends TestCase
{
    public function testItWillCreateFromPerfectPayload(): void
    {
        $interaction = Interaction::fromArray([
            'description' => PayloadExample::description(),
            'provider_states' => PayloadExample::providerStates(),
            'consumer_request' => PayloadExample::consumerRequest(),
            'provider_response' => PayloadExample::providerResponse(),
        ]);

        $payload = $interaction->toArray();

        Assert::assertArrayHasKey('description', $payload);
        Assert::assertArrayHasKey('provider_states', $payload);
        Assert::assertArrayHasKey('consumer_request', $payload);
        Assert::assertArrayHasKey('provider_response', $payload);
    }

    #[DataProvider('invalidPayloadProvider')]
    public function testItWillThrowWithInvalidPayload(\Exception $expectedException, array $payloadExample): void
    {
        $this->expectExceptionObject($expectedException);

        Interaction::fromArray($payloadExample);
    }

    /**
     * @return iterable<array-key, array{0: \Exception, 1: array}>
     */
    public static function invalidPayloadProvider(): iterable
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
