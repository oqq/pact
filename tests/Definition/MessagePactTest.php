<?php

declare(strict_types=1);

namespace Oqq\PactTest\Definition;

use Oqq\Pact\Definition\MessagePact;
use Oqq\PactTest\ValueObjectPayloadAssertion;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(\Oqq\Pact\Definition\MessagePact::class)]
final class MessagePactTest extends TestCase
{
    public function testItWillCreateFromPerfectPayload(): void
    {
        $pact = MessagePact::fromArray([
            'consumer' => ['name' => 'test-consumer'],
            'provider' => ['name' => 'test-provider'],
            'messages' => [],
        ]);

        Assert::assertSame(['name' => 'test-consumer'], $pact->consumer()->toArray());
        Assert::assertSame(['name' => 'test-provider'], $pact->provider()->toArray());
        Assert::assertSame([], $pact->messages()->toArray());

        Assert::assertArrayHasKey('consumer', $pact->toArray());
        Assert::assertArrayHasKey('provider', $pact->toArray());
        Assert::assertArrayHasKey('messages', $pact->toArray());
    }

    #[DataProvider('invalidPayloadProvider')]
    public function testItWillThrowWithInvalidPayload(\Exception $expectedException, array $payloadExample): void
    {
        $this->expectExceptionObject($expectedException);

        MessagePact::fromArray($payloadExample);
    }

    /**
     * @return iterable<array-key, array{0: \Exception, 1: array}>
     */
    public static function invalidPayloadProvider(): iterable
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
