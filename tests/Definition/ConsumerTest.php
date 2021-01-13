<?php

declare(strict_types=1);

namespace Oqq\PactTest\Definition;

use Oqq\Pact\Definition\Consumer;
use Oqq\PactTest\ValueObjectPayloadAssertion;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Oqq\Pact\Definition\Consumer
 */
final class ConsumerTest extends TestCase
{
    public function testItWillCreateFromPerfectPayload(): void
    {
        $consumer = Consumer::fromArray([
            'name' =>  'test',
        ]);

        $payload = $consumer->toArray();

        Assert::assertArrayHasKey('name', $payload);
        Assert::assertSame('test', $payload['name']);
        Assert::assertSame('test', $consumer->name());
    }

    /**
     * @dataProvider invalidPayloadProvider
     */
    public function testItWillThrowWithInvalidPayload(\Exception $expectedException, array $payloadExample): void
    {
        $this->expectExceptionObject($expectedException);

        Consumer::fromArray($payloadExample);
    }

    /**
     * @return iterable<array-key, array{0: \Exception, 1: array}>
     */
    public function invalidPayloadProvider(): iterable
    {
        $perfectValues = [
            'name' =>  'test',
        ];

        yield from ValueObjectPayloadAssertion::string($perfectValues, 'name');
    }
}
