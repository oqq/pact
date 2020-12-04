<?php

declare(strict_types=1);

namespace Oqq\PactTest\Definition;

use Oqq\Pact\Definition\MessagePact;
use Oqq\PactTest\ValueObjectPayloadAssertion;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Oqq\Pact\Definition\MessagePact
 */
final class MessagePactTest extends TestCase
{
    public function testItWillCreateFromPerfectPayload(): void
    {
        $pact = MessagePact::fromArray([
            'consumer' => PayloadExample::consumer(),
            'provider' => PayloadExample::provider(),
            'messages' => PayloadExample::messages(),
        ]);

        $payload = $pact->toArray();

        Assert::assertArrayHasKey('consumer', $payload);
        Assert::assertArrayHasKey('provider', $payload);
        Assert::assertArrayHasKey('messages', $payload);
    }

    /**
     * @dataProvider invalidPayloadProvider
     */
    public function testItWillThrowWithInvalidPayload(\Exception $expectedException, array $payloadExample): void
    {
        $this->expectExceptionObject($expectedException);

        MessagePact::fromArray($payloadExample);
    }

    /**
     * @return iterable<array-key, array{0: \Exception, 1: array}>
     */
    public function invalidPayloadProvider(): iterable
    {
        $perfectValues = [
            'consumer' => PayloadExample::consumer(),
            'provider' => PayloadExample::provider(),
            'messages' => PayloadExample::messages(),
        ];

        yield from ValueObjectPayloadAssertion::array($perfectValues, 'consumer');
        yield from ValueObjectPayloadAssertion::array($perfectValues, 'provider');
        yield from ValueObjectPayloadAssertion::array($perfectValues, 'messages');
    }
}
