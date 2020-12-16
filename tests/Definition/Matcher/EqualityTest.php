<?php

declare(strict_types=1);

namespace Oqq\PactTest\Definition\Matcher;

use Oqq\Pact\Definition\Matcher\Equality;
use Oqq\Pact\Exception\InvalidArgumentException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Oqq\Pact\Definition\Matcher\Equality
 */
final class EqualityTest extends TestCase
{
    public function testItWillCreateFromPerfectPayload(): void
    {
        $matcher = Equality::fromArray([
            'type' =>  'equality',
        ]);

        Assert::assertSame('equality', $matcher->type());

        $payload = $matcher->toArray();

        Assert::assertArrayHasKey('type', $payload);
        Assert::assertSame('equality', $payload['type']);
    }

    /**
     * @dataProvider invalidPayloadProvider
     */
    public function testItWillThrowWithInvalidPayload(\Exception $expectedException, array $payloadExample): void
    {
        $this->expectExceptionObject($expectedException);

        Equality::fromArray($payloadExample);
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
            new InvalidArgumentException('Expected a value identical to "equality". Got: "invalid"'),
            [
                'type' => 'invalid',
            ],
        ];
    }
}
