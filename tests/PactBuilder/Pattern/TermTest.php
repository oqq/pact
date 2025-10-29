<?php

declare(strict_types=1);

namespace Oqq\PactTest\PactBuilder\Pattern;

use Oqq\Pact\Definition\Matcher\Regex;
use Oqq\Pact\Exception\InvalidArgumentException;
use Oqq\Pact\PactBuilder\Pattern\Term;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(\Oqq\Pact\PactBuilder\Pattern\Term::class)]
final class TermTest extends TestCase
{
    public function testItWillCreateFromPerfectPayload(): void
    {
        $pattern = Term::generateWithPattern('value', '.*');

        Assert::assertSame('value', $pattern->generate());

        $matcher = $pattern->matcher();
        Assert::assertInstanceOf(Regex::class, $matcher);
        Assert::assertSame('.*', $matcher->pattern());
    }

    public function testItThrowsWithInvalidPattern(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The value "value" does not match the expected pattern');

        Term::generateWithPattern('value', '[0-9]');
    }
}
