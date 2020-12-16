<?php

declare(strict_types=1);

namespace Oqq\PactTest\Definition\Matcher;

use Oqq\Pact\Definition\Matcher\Integer;
use Oqq\Pact\Exception\InvalidArgumentException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Oqq\Pact\Definition\Matcher\Integer
 */
final class IntegerTest extends TestCase
{
    public function testItWillCreateFromPerfectPayload(): void
    {
        $matcher = Integer::fromArray([
            'type' =>  'integer',
        ]);

        Assert::assertSame('integer', $matcher->type());

        $payload = $matcher->toArray();

        Assert::assertArrayHasKey('type', $payload);
        Assert::assertSame('integer', $payload['type']);
    }


    /**
     * @dataProvider invalidPayloadProvider
     */
    public function testItWillThrowWithInvalidPayload(\Exception $expectedException, array $payloadExample): void
    {
        $this->expectExceptionObject($expectedException);

        Integer::fromArray($payloadExample);
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
            new InvalidArgumentException('Expected a value identical to "integer". Got: "invalid"'),
            [
                'type' => 'invalid',
            ],
        ];
    }
}
