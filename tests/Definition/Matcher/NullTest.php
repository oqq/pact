<?php

declare(strict_types=1);

namespace Oqq\PactTest\Definition\Matcher;

use Oqq\Pact\Definition\Matcher\Null_;
use Oqq\Pact\Exception\InvalidArgumentException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Oqq\Pact\Definition\Matcher\Null_
 */
final class NullTest extends TestCase
{
    public function testItWillCreateFromPerfectPayload(): void
    {
        $matcher = Null_::fromArray([
            'match' =>  'null',
        ]);

        Assert::assertSame('null', $matcher->match());

        $payload = $matcher->toArray();

        Assert::assertArrayHasKey('match', $payload);
        Assert::assertSame('null', $payload['match']);
    }


    /**
     * @dataProvider invalidPayloadProvider
     */
    public function testItWillThrowWithInvalidPayload(\Exception $expectedException, array $payloadExample): void
    {
        $this->expectExceptionObject($expectedException);

        /** @psalm-suppress ArgumentTypeCoercion */
        Null_::fromArray($payloadExample);
    }

    /**
     * @return iterable<array-key, array{0: \Exception, 1: array}>
     */
    public function invalidPayloadProvider(): iterable
    {
        yield 'missing type' => [
            new InvalidArgumentException('Expected the key "match" to exist.'),
            [],
        ];

        yield 'invalid type' => [
            new InvalidArgumentException('Expected a value identical to "null". Got: "invalid"'),
            [
                'match' => 'invalid',
            ],
        ];
    }
}
