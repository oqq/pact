<?php

declare(strict_types=1);

namespace Oqq\PactTest\Definition;

use Oqq\Pact\Definition\Provider;
use Oqq\PactTest\ValueObjectPayloadAssertion;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Oqq\Pact\Definition\Provider
 */
final class ProviderTest extends TestCase
{
    public function testItWillCreateFromPerfectPayload(): void
    {
        $provider = Provider::fromArray([
            'name' =>  'test',
        ]);

        $payload = $provider->toArray();

        Assert::assertArrayHasKey('name', $payload);
        Assert::assertSame('test', $payload['name']);
    }

    /**
     * @dataProvider invalidPayloadProvider
     */
    public function testItWillThrowWithInvalidPayload(\Exception $expectedException, array $payloadExample): void
    {
        $this->expectExceptionObject($expectedException);

        Provider::fromArray($payloadExample);
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
