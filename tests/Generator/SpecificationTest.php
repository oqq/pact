<?php

declare(strict_types=1);

namespace Oqq\PactTest\Generator;

use Oqq\Pact\Generator\Specification;
use Oqq\PactTest\ValueObjectPayloadAssertion;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Specification::class)]
final class SpecificationTest extends TestCase
{
    public function testItWillCreateFromPerfectPayload(): void
    {
        $specification = Specification::fromArray([
            'version' =>  '3.0.0',
        ]);

        Assert::assertSame('3.0.0', $specification->version());

        $payload = $specification->toArray();
        Assert::assertArrayHasKey('version', $payload);
    }


    #[DataProvider('invalidPayloadProvider')]
    public function testItWillThrowWithInvalidPayload(\Exception $expectedException, array $payloadExample): void
    {
        $this->expectExceptionObject($expectedException);

        Specification::fromArray($payloadExample);
    }

    /**
     * @return iterable<array-key, array{0: \Exception, 1: array}>
     */
    public static function invalidPayloadProvider(): iterable
    {
        $perfectValues = [
            'version' =>  '3.0.0',
        ];

        yield from ValueObjectPayloadAssertion::string($perfectValues, 'version');
    }
}
