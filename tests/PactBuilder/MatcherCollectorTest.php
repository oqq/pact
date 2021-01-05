<?php

declare(strict_types=1);

namespace Oqq\PactTest\PactBuilder;

use Oqq\Pact\Definition\Matcher;
use Oqq\Pact\PactBuilder\MatcherCollector;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Oqq\Pact\PactBuilder\MatcherCollector
 */
final class MatcherCollectorTest extends TestCase
{
    public function testItCollectsMatchers(): void
    {
        $collector = new MatcherCollector();
        $collector->addMatcher('$.foo.bar', Matcher::create(['match' => 'type']));
        $collector->addMatcher('$.foo.bar', Matcher::create(['match' => 'type']));

        Assert::assertSame([
            '$.foo.bar' => [
                'matchers' => [
                    ['match' => 'type'],
                    ['match' => 'type'],
                ],
            ],
        ], $collector->generateMatchingRules());
    }
}
