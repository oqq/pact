<?php

declare(strict_types=1);

namespace Oqq\Pact\PactBuilder;

use Oqq\Pact\Definition\Body;
use Oqq\Pact\PactBuilder\Pattern\EachLike;

/**
 * @psalm-import-type JsonPatternType from Pattern
 */
final class JsonPatternBuilder
{
    /** @var array<JsonPatternType> */
    private array $content = [];

    /**
     * @param array<JsonPatternType> $content
     */
    public function withPattern(array $content): self
    {
        $clone = clone $this;
        $clone->content = $content;

        return $clone;
    }

    public function build(): Body
    {
        $matchers = new MatcherCollector();
        $content = self::extractRecursiveMatchingRules($this->content, '$', $matchers);

        return Body::fromArray([
            'content' => $content,
            'matching_rules' => $matchers->generateMatchingRules(),
        ]);
    }

    /**
     * @param null|scalar|array $value
     */
    public function like($value): Pattern\Like
    {
        return Pattern\Like::generateFromValue($value);
    }

    /**
     * @param JsonPatternType $value
     */
    public function eachLike($value, int $min = 1): Pattern\EachLike
    {
        return Pattern\EachLike::generateFromValue($value, $min);
    }

    public function term(string $value, string $pattern): Pattern\Term
    {
        return Pattern\Term::generateWithPattern($value, $pattern);
    }

    /**
     * @param array<JsonPatternType> $contents
     * @return array<null|scalar|array>
     */
    private static function extractRecursiveMatchingRules(array $contents, string $path, MatcherCollector $matchers): array
    {
        $values = [];

        foreach ($contents as $key => $content) {
            $values[$key] = self::extractMatchingRules($content, self::createPath($path, $key), $matchers);
        }

        return $values;
    }

    /**
     * @param array<JsonPatternType>|JsonPatternType $content
     * @return null|scalar|array
     */
    private static function extractMatchingRules($content, string $path, MatcherCollector $matchers)
    {
        if (\is_array($content)) {
            /** @var array<JsonPatternType> $content */
            return self::extractRecursiveMatchingRules($content, $path, $matchers);
        }

        if ($content instanceof EachLike) {
            $matchers->addMatcher($path, $content->matcher());

            $content = $content->generate();
            $path .= \is_array($content) ? '.*' : '[*]';

            return [self::extractMatchingRules($content, $path, $matchers)];
        }

        if ($content instanceof Pattern) {
            $matchers->addMatcher($path, $content->matcher());

            return self::extractMatchingRules($content->generate(), $path, $matchers);
        }

        return $content;
    }

    /**
     * @param int|string $key
     */
    private static function createPath(string $path, $key): string
    {
        if (\is_numeric($key)) {
            return \sprintf('%s[%s]', $path, $key);
        }

        if (false !== \strpbrk($key, '.[]()"\'')) {
            return \sprintf("%s['%s']", $path, $key);
        }

        return \sprintf('%s.%s', $path, $key);
    }
}
