<?php

declare(strict_types=1);

namespace Oqq\PactTest\Definition;

use Oqq\Pact\Definition\Messages;
use Oqq\Pact\Exception\InvalidArgumentException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Messages::class)]
final class MessagesTest extends TestCase
{
    public function testItWillCreateFromPerfectPayload(): void
    {
        $messages = Messages::fromArray([
            PayloadExample::message(),
            PayloadExample::message(),
        ]);

        Assert::assertContainsOnlyArray($messages->toArray());
        Assert::assertCount(2, $messages->toArray());
    }

    #[DataProvider('invalidPayloadProvider')]
    public function testItWillThrowWithInvalidPayload(\Exception $expectedException, array $payloadExample): void
    {
        $this->expectExceptionObject($expectedException);

        Messages::fromArray($payloadExample);
    }

    /**
     * @return iterable<array-key, array{0: \Exception, 1: array}>
     */
    public static function invalidPayloadProvider(): iterable
    {
        yield 'invalid type for message value' => [
            new InvalidArgumentException('Expected an array. Got: integer'),
            [5],
        ];
        yield 'invalid array keys' => [
            new InvalidArgumentException('Expected list - non-associative array.'),
            ['x' => PayloadExample::message()],
        ];
    }
}
