<?php

declare(strict_types=1);

namespace Oqq\PactTest\PactBuilder\Pattern;

use Oqq\Pact\Definition\Matcher\Type;
use Oqq\Pact\PactBuilder\Pattern\Like;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Oqq\Pact\PactBuilder\Pattern\Like
 */
final class LikeTest extends TestCase
{
    public function testItWillCreateFromPerfectPayload(): void
    {
        $pattern = Like::generateFromValue('value');

        Assert::assertSame('value', $pattern->generate());

        $matcher = $pattern->matcher();
        Assert::assertInstanceOf(Type::class, $matcher);
    }
}
