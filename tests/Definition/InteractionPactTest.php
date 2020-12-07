<?php

declare(strict_types=1);

namespace Oqq\PactTest\Definition;

use Oqq\Pact\Definition\InteractionPact;
use Oqq\PactTest\ValueObjectPayloadAssertion;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Oqq\Pact\Definition\InteractionPact
 */
final class InteractionPactTest extends TestCase
{
    public function testItWillCreateFromPerfectPayload(): void
    {
        $pact = InteractionPact::fromArray([
            'consumer' => PayloadExample::consumer(),
            'provider' => PayloadExample::provider(),
            'interactions' => PayloadExample::interactions(),
        ]);

        $payload = $pact->toArray();

        Assert::assertArrayHasKey('consumer', $payload);
        Assert::assertArrayHasKey('provider', $payload);
        Assert::assertArrayHasKey('interactions', $payload);
    }

    /**
     * @dataProvider invalidPayloadProvider
     */
    public function testItWillThrowWithInvalidPayload(\Exception $expectedException, array $payloadExample): void
    {
        $this->expectExceptionObject($expectedException);

        InteractionPact::fromArray($payloadExample);
    }

    /**
     * @return iterable<array-key, array{0: \Exception, 1: array}>
     */
    public function invalidPayloadProvider(): iterable
    {
        $perfectValues = [
            'consumer' => PayloadExample::consumer(),
            'provider' => PayloadExample::provider(),
            'interactions' => PayloadExample::interactions(),
        ];

        yield from ValueObjectPayloadAssertion::array($perfectValues, 'consumer');
        yield from ValueObjectPayloadAssertion::array($perfectValues, 'provider');
        yield from ValueObjectPayloadAssertion::array($perfectValues, 'interactions');
    }
}
