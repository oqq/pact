<?php

declare(strict_types=1);

namespace Oqq\PactTest\Definition;

use Oqq\Pact\Definition\ProviderStates;
use Oqq\Pact\Exception\InvalidArgumentException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(\Oqq\Pact\Definition\ProviderStates::class)]
final class ProviderStatesTest extends TestCase
{
    #[DataProvider('validValueProvider')]
    public function testItWillCreateFromPerfectPayload(array $payloadExample): void
    {
        $states = ProviderStates::fromArray($payloadExample);

        Assert::assertCount(\count($payloadExample), $states->toArray());
        Assert::assertContainsOnlyArray($states->toArray());
    }

    /**
     * @return iterable<array-key, array<array>>
     */
    public static function validValueProvider(): iterable
    {
        yield 'empty list' => [
            [],
        ];

        yield 'one state' => [
            [
                PayloadExample::providerState(),
            ],
        ];

        yield 'two states' => [
            [
                PayloadExample::providerState(),
                PayloadExample::providerState(),
            ],
        ];
    }

    #[DataProvider('invalidPayloadProvider')]
    public function testItWillThrowWithInvalidPayload(\Exception $expectedException, array $payloadExample): void
    {
        $this->expectExceptionObject($expectedException);

        ProviderStates::fromArray($payloadExample);
    }

    /**
     * @return iterable<array-key, array{0: \Exception, 1: array}>
     */
    public static function invalidPayloadProvider(): iterable
    {
        yield 'invalid type' => [
            new InvalidArgumentException('Expected an array. Got: integer'),
            [5],
        ];
        yield 'invalid array key' => [
            new InvalidArgumentException('Expected list - non-associative array.'),
            ['x' => PayloadExample::providerState()],
        ];
    }
}
