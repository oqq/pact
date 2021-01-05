<?php

declare(strict_types=1);

namespace Oqq\PactTest\Definition\Matcher;

use Oqq\Pact\Definition\Matcher\Include_;
use Oqq\Pact\Exception\InvalidArgumentException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Oqq\Pact\Definition\Matcher\Include_
 */
final class IncludeTest extends TestCase
{
    public function testItWillCreateFromPerfectPayload(): void
    {
        $matcher = Include_::fromArray([
            'match' =>  'include',
            'value' => 'something',
        ]);

        Assert::assertSame('include', $matcher->match());
        Assert::assertSame('something', $matcher->value());

        $payload = $matcher->toArray();

        Assert::assertArrayHasKey('match', $payload);
        Assert::assertSame('include', $payload['match']);

        Assert::assertArrayHasKey('value', $payload);
        Assert::assertSame('something', $payload['value']);
    }


    /**
     * @dataProvider invalidPayloadProvider
     */
    public function testItWillThrowWithInvalidPayload(\Exception $expectedException, array $payloadExample): void
    {
        $this->expectExceptionObject($expectedException);

        Include_::fromArray($payloadExample);
    }

    /**
     * @return iterable<array-key, array{0: \Exception, 1: array}>
     */
    public function invalidPayloadProvider(): iterable
    {
        yield 'missing type' => [
            new InvalidArgumentException('Expected the key "match" to exist.'),
            [
                'include' => 'something',
            ],
        ];

        yield 'invalid type' => [
            new InvalidArgumentException('Expected a value identical to "include". Got: "invalid"'),
            [
                'match' => 'invalid',
                'include' => 'something',
            ],
        ];

        yield 'missing value' => [
            new InvalidArgumentException('Expected the key "value" to exist.'),
            [
                'match' => 'include',
            ],
        ];

        yield 'invalid value' => [
            new InvalidArgumentException('Expected a string. Got: integer'),
            [
                'match' => 'include',
                'value' => 5,
            ],
        ];
    }
}
