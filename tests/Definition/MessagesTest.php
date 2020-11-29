<?php

declare(strict_types=1);

namespace Oqq\PactTest\Definition;

use Oqq\Pact\Definition\Messages;
use Oqq\Pact\Exception\InvalidArgumentException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Oqq\Pact\Definition\Messages
 */
final class MessagesTest extends TestCase
{
    public function testItWillCreateFromPerfectPayload(): void
    {
        $messages = Messages::fromArray([
            PayloadExample::message(),
            PayloadExample::message(),
        ]);

        Assert::assertContainsOnly('array', $messages->toArray());
    }

    /**
     * @dataProvider invalidPayloadProvider
     */
    public function testItWillThrowWithInvalidPayload(\Exception $expectedException, array $payloadExample): void
    {
        $this->expectExceptionObject($expectedException);

        Messages::fromArray($payloadExample);
    }

    /**
     * @return iterable<array-key, array{0: \Exception, 1: array}>
     */
    public function invalidPayloadProvider(): iterable
    {
        yield 'invalid type for message value' => [
            new InvalidArgumentException('Expected an array. Got: integer'),
            [5],
        ];
    }
}
