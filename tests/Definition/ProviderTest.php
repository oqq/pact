<?php

declare(strict_types=1);

namespace Oqq\PactTest\Definition;

use Oqq\Pact\Definition\Provider;
use Oqq\PactTest\ValueObjectPayloadAssertion;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Provider::class)]
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
        Assert::assertSame('test', $provider->name());
    }

    #[DataProvider('invalidPayloadProvider')]
    public function testItWillThrowWithInvalidPayload(\Exception $expectedException, array $payloadExample): void
    {
        $this->expectExceptionObject($expectedException);

        Provider::fromArray($payloadExample);
    }

    /**
     * @return iterable<array-key, array{0: \Exception, 1: array}>
     */
    public static function invalidPayloadProvider(): iterable
    {
        $perfectValues = [
            'name' =>  'test',
        ];

        yield from ValueObjectPayloadAssertion::string($perfectValues, 'name');
    }
}
