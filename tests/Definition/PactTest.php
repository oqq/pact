<?php

declare(strict_types=1);

namespace Oqq\PactTest\Definition;

use Oqq\Pact\Definition\Pact;
use Oqq\PactTest\ValueObjectPayloadAssertion;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Oqq\Pact\Definition\Pact
 */
final class PactTest extends TestCase
{
    public function testItWillCreateFromPerfectPayload(): void
    {
        $pact = Pact::fromArray([
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

        Pact::fromArray($payloadExample);
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
