<?php

declare(strict_types=1);

namespace Oqq\PactTest\PactBuilder\Pattern;

use Oqq\Pact\Definition\Matcher\Collection;
use Oqq\Pact\Exception\InvalidArgumentException;
use Oqq\Pact\PactBuilder\Pattern\EachLike;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Oqq\Pact\PactBuilder\Pattern\EachLike
 */
final class EachLikeTest extends TestCase
{
    public function testItWillCreateFromPerfectPayload(): void
    {
        $pattern = EachLike::generateFromValue('value', 5);

        Assert::assertSame('value', $pattern->generate());

        $matcher = $pattern->matcher();
        Assert::assertInstanceOf(Collection::class, $matcher);
        Assert::assertSame(5, $matcher->min());
    }

    public function testItThrowsWithInvalidMin(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected a value greater than or equal to 1. Got: 0');

        EachLike::generateFromValue('value', 0);
    }
}
