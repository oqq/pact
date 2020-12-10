<?php

declare(strict_types=1);

namespace Oqq\PactTest\PactBuilder;

use Oqq\Pact\Exception\InvalidArgumentException;
use Oqq\Pact\PactBuilder\Term;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Oqq\Pact\PactBuilder\Term
 */
final class TermTest extends TestCase
{
    public function testItWillCreateFromPerfectPayload(): void
    {
        $term = Term::generateWithPattern('value', '/.*/');

        Assert::assertSame('value', $term->generate());
        Assert::assertSame('/.*/', $term->pattern());
    }

    public function testItThrowsWithInvalidPattern(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The value "value" does not match the expected pattern');

        Term::generateWithPattern('value', '/[0-9]/');
    }
}
