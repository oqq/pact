<?php

declare(strict_types=1);

namespace Oqq\PactTest\Generator;

use Oqq\Pact\Generator\Specification;
use Oqq\PactTest\ValueObjectPayloadAssertion;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Oqq\Pact\Generator\Specification
 */
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

    /**
     * @dataProvider invalidPayloadProvider
     */
    public function testItWillThrowWithInvalidPayload(\Exception $expectedException, array $payloadExample): void
    {
        $this->expectExceptionObject($expectedException);

        Specification::fromArray($payloadExample);
    }

    /**
     * @return iterable<array-key, array{0: \Exception, 1: array}>
     */
    public function invalidPayloadProvider(): iterable
    {
        $perfectValues = [
            'version' =>  '3.0.0',
        ];

        yield from ValueObjectPayloadAssertion::string($perfectValues, 'version');
    }
}
