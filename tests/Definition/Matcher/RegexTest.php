<?php

declare(strict_types=1);

namespace Oqq\PactTest\Definition\Matcher;

use Oqq\Pact\Definition\Matcher\Regex;
use Oqq\Pact\Exception\InvalidArgumentException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Oqq\Pact\Definition\Matcher\Regex
 */
final class RegexTest extends TestCase
{
    public function testItWillCreateFromPerfectPayload(): void
    {
        $matcher = Regex::fromArray([
            'type' =>  'regex',
            'pattern' => '.+',
        ]);

        Assert::assertSame('regex', $matcher->type());
        Assert::assertSame('.+', $matcher->pattern());

        $payload = $matcher->toArray();

        Assert::assertArrayHasKey('type', $payload);
        Assert::assertSame('regex', $payload['type']);

        Assert::assertArrayHasKey('pattern', $payload);
        Assert::assertSame('.+', $payload['pattern']);
    }


    /**
     * @dataProvider invalidPayloadProvider
     */
    public function testItWillThrowWithInvalidPayload(\Exception $expectedException, array $payloadExample): void
    {
        $this->expectExceptionObject($expectedException);

        Regex::fromArray($payloadExample);
    }

    /**
     * @return iterable<array-key, array{0: \Exception, 1: array}>
     */
    public function invalidPayloadProvider(): iterable
    {
        yield 'missing type' => [
            new InvalidArgumentException('Expected the key "type" to exist.'),
            [],
        ];

        yield 'invalid type' => [
            new InvalidArgumentException('Expected a value identical to "regex". Got: "invalid"'),
            [
                'type' => 'invalid',
            ],
        ];

        yield 'missing pattern' => [
            new InvalidArgumentException('Expected the key "pattern" to exist.'),
            [
                'type' => 'regex',
            ],
        ];

        yield 'invalid pattern' => [
            new InvalidArgumentException('Expected a string. Got: integer'),
            [
                'type' => 'regex',
                'pattern' => 5,
            ],
        ];
    }
}
