<?php

declare(strict_types=1);

namespace Oqq\PactTest\Definition;

use Oqq\Pact\Definition\ConsumerRequest;
use Oqq\PactTest\ValueObjectPayloadAssertion;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(\Oqq\Pact\Definition\ConsumerRequest::class)]
final class ConsumerRequestTest extends TestCase
{
    public function testItWillCreateFromPerfectPayload(): void
    {
        $request = ConsumerRequest::fromArray([
            'method' =>  PayloadExample::method(),
            'path' => PayloadExample::path(),
            'query' => PayloadExample::query(),
            'headers' => PayloadExample::headers(),
            'body' => PayloadExample::body(),
        ]);

        $payload = $request->toArray();

        Assert::assertArrayHasKey('method', $payload);
        Assert::assertArrayHasKey('path', $payload);
        Assert::assertArrayHasKey('query', $payload);
        Assert::assertArrayHasKey('headers', $payload);
        Assert::assertArrayHasKey('body', $payload);
    }

    #[DataProvider('invalidPayloadProvider')]
    public function testItWillThrowWithInvalidPayload(\Exception $expectedException, array $payloadExample): void
    {
        $this->expectExceptionObject($expectedException);

        ConsumerRequest::fromArray($payloadExample);
    }

    /**
     * @return iterable<array-key, array{0: \Exception, 1: array}>
     */
    public static function invalidPayloadProvider(): iterable
    {
        $perfectValues = [
            'method' =>  PayloadExample::method(),
            'path' => PayloadExample::path(),
            'query' => PayloadExample::query(),
            'headers' => PayloadExample::headers(),
            'body' => PayloadExample::body(),
        ];

        yield from ValueObjectPayloadAssertion::string($perfectValues, 'method');
        yield from ValueObjectPayloadAssertion::array($perfectValues, 'path');
        yield from ValueObjectPayloadAssertion::array($perfectValues, 'query');
        yield from ValueObjectPayloadAssertion::array($perfectValues, 'headers');
        yield from ValueObjectPayloadAssertion::array($perfectValues, 'body');
    }
}
