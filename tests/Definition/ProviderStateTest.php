<?php

declare(strict_types=1);

namespace Oqq\PactTest\Definition;

use Oqq\Pact\Definition\ProviderState;
use Oqq\PactTest\ValueObjectPayloadAssertion;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(\Oqq\Pact\Definition\ProviderState::class)]
final class ProviderStateTest extends TestCase
{
    #[DataProvider('validValueProvider')]
    public function testItWillCreateFromPerfectPayload(array $payloadExample): void
    {
        $state = ProviderState::fromArray($payloadExample);

        $payload = $state->toArray();

        Assert::assertArrayHasKey('name', $payload);
        Assert::assertArrayHasKey('params', $payload);
    }

    /**
     * @return iterable<array-key, array<array>>
     */
    public static function validValueProvider(): iterable
    {
        yield 'full example' => [
            [
                'name' => 'test',
                'params' => [
                    'some' => 'value',
                    'other' => 5,
                    'deep' => [
                        'values' => ['some' => 'value'],
                    ],
                ],
            ],
        ];

        yield 'empty params' => [
            [
                'name' => 'test',
                'params' => [],
            ],
        ];
    }

    #[DataProvider('invalidPayloadProvider')]
    public function testItWillThrowWithInvalidPayload(\Exception $expectedException, array $payloadExample): void
    {
        $this->expectExceptionObject($expectedException);

        ProviderState::fromArray($payloadExample);
    }

    /**
     * @return iterable<array-key, array{0: \Exception, 1: array}>
     */
    public static function invalidPayloadProvider(): iterable
    {
        $perfectValues = [
            'name' => 'test',
            'params' => [
                'some' => 'value',
            ],
        ];

        yield from ValueObjectPayloadAssertion::string($perfectValues, 'name');
        yield from ValueObjectPayloadAssertion::map($perfectValues, 'params');
    }
}
