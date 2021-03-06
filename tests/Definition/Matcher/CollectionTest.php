<?php

declare(strict_types=1);

namespace Oqq\PactTest\Definition\Matcher;

use Oqq\Pact\Definition\Matcher\Collection;
use Oqq\Pact\Exception\InvalidArgumentException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Oqq\Pact\Definition\Matcher\Collection
 */
final class CollectionTest extends TestCase
{
    public function testItWillCreateFromPerfectPayload(): void
    {
        $matcher = Collection::fromArray([
            'match' =>  'collection',
            'min' => 1,
        ]);

        Assert::assertSame('collection', $matcher->match());
        Assert::assertSame(1, $matcher->min());

        $payload = $matcher->toArray();

        Assert::assertArrayHasKey('match', $payload);
        Assert::assertSame('collection', $payload['match']);
        Assert::assertArrayHasKey('min', $payload);
        Assert::assertSame(1, $payload['min']);
    }


    /**
     * @dataProvider invalidPayloadProvider
     */
    public function testItWillThrowWithInvalidPayload(\Exception $expectedException, array $payloadExample): void
    {
        $this->expectExceptionObject($expectedException);

        /** @psalm-suppress ArgumentTypeCoercion */
        Collection::fromArray($payloadExample);
    }

    /**
     * @return iterable<array-key, array{0: \Exception, 1: array}>
     */
    public function invalidPayloadProvider(): iterable
    {
        yield 'missing type' => [
            new InvalidArgumentException('Expected the key "match" to exist.'),
            [
                'min' => 1,
            ],
        ];

        yield 'invalid type' => [
            new InvalidArgumentException('Expected a value identical to "collection". Got: "invalid"'),
            [
                'match' => 'invalid',
                'min' => 1,
            ],
        ];

        yield 'missing min' => [
            new InvalidArgumentException('Expected the key "min" to exist.'),
            [
                'match' => 'collection',
            ],
        ];

        yield 'invalid min' => [
            new InvalidArgumentException('Expected an integer. Got: string'),
            [
                'match' => 'collection',
                'min' => '0',
            ],
        ];

        yield 'out of bounds min' => [
            new InvalidArgumentException('Expected a value greater than or equal to 1. Got: 0'),
            [
                'match' => 'collection',
                'min' => 0,
            ],
        ];
    }
}
