<?php

declare(strict_types=1);

namespace Oqq\PactTest\Definition;

use Oqq\Pact\Definition\Matcher;
use Oqq\Pact\Exception\InvalidArgumentException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Matcher::class)]
final class MatcherTest extends TestCase
{
    public function testItWillCreateFromPerfectPayload(): void
    {
        $matcher = Matcher::create([
            'match' => 'type',
        ]);

        Assert::assertInstanceOf(Matcher\Type::class, $matcher);
    }

    public function testItWillThrowWithMissingTypeValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected the key "match" to exist');

        Matcher::create([
        ]);
    }

    public function testItWillThrowWithInvalidTypeValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/Expected one of: [^\.]+\. Got: "invalid"/');

        Matcher::create([
            'match' => 'invalid',
        ]);
    }
}
