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
            'type' =>  'include',
            'include' => 'something',
        ]);

        $payload = $matcher->toArray();

        Assert::assertArrayHasKey('type', $payload);
        Assert::assertSame('include', $payload['type']);

        Assert::assertArrayHasKey('include', $payload);
        Assert::assertSame('something', $payload['include']);
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
            new InvalidArgumentException('Expected the key "type" to exist.'),
            [
                'include' => 'something',
            ],
        ];

        yield 'invalid type' => [
            new InvalidArgumentException('Expected a value identical to "include". Got: "invalid"'),
            [
                'type' => 'invalid',
                'include' => 'something',
            ],
        ];

        yield 'missing include' => [
            new InvalidArgumentException('Expected the key "include" to exist.'),
            [
                'type' => 'include',
            ],
        ];

        yield 'invalid include' => [
            new InvalidArgumentException('Expected a string. Got: integer'),
            [
                'type' => 'include',
                'include' => 5,
            ],
        ];
    }
}
