<?php

declare(strict_types=1);

namespace Oqq\PactTest\Definition;

use Oqq\Pact\Definition\ProviderState;
use Oqq\PactTest\ValueObjectPayloadAssertion;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Oqq\Pact\Definition\ProviderState
 */
final class ProviderStateTest extends TestCase
{
    /**
     * @dataProvider validValueProvider
     */
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
    public function validValueProvider(): iterable
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

    /**
     * @dataProvider invalidPayloadProvider
     */
    public function testItWillThrowWithInvalidPayload(\Exception $expectedException, array $payloadExample): void
    {
        $this->expectExceptionObject($expectedException);

        ProviderState::fromArray($payloadExample);
    }

    /**
     * @return iterable<array-key, array{0: \Exception, 1: array}>
     */
    public function invalidPayloadProvider(): iterable
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
