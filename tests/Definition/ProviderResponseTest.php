<?php

declare(strict_types=1);

namespace Oqq\PactTest\Definition;

use Oqq\Pact\Definition\ProviderResponse;
use Oqq\PactTest\ValueObjectPayloadAssertion;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(\Oqq\Pact\Definition\ProviderResponse::class)]
final class ProviderResponseTest extends TestCase
{
    public function testItWillCreateFromPerfectPayload(): void
    {
        $response = ProviderResponse::fromArray([
            'status' =>  PayloadExample::status(),
            'headers' => PayloadExample::headers(),
            'body' => PayloadExample::body(),
        ]);

        $payload = $response->toArray();

        Assert::assertArrayHasKey('status', $payload);
        Assert::assertIsInt($payload['status']);

        Assert::assertArrayHasKey('headers', $payload);
        Assert::assertIsArray($payload['headers']);

        Assert::assertArrayHasKey('body', $payload);
        Assert::assertIsArray($payload['body']);
    }

    #[DataProvider('invalidPayloadProvider')]
    public function testItWillThrowWithInvalidPayload(\Exception $expectedException, array $payloadExample): void
    {
        $this->expectExceptionObject($expectedException);

        ProviderResponse::fromArray($payloadExample);
    }

    /**
     * @return iterable<array-key, array{0: \Exception, 1: array}>
     */
    public static function invalidPayloadProvider(): iterable
    {
        $perfectValues = [
            'status' =>  PayloadExample::status(),
            'headers' => PayloadExample::headers(),
            'body' => PayloadExample::body(),
        ];

        yield from ValueObjectPayloadAssertion::integer($perfectValues, 'status');
        yield from ValueObjectPayloadAssertion::array($perfectValues, 'headers');
        yield from ValueObjectPayloadAssertion::array($perfectValues, 'body');
    }
}
