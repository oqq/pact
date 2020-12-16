<?php

declare(strict_types=1);

namespace Oqq\Pact\PactBuilder;

use Oqq\Pact\Definition\Body;

final class JsonPatternBuilder
{
    /** @var array<null|scalar|array|Pattern> */
    private array $content = [];

    /**
     * @param array<null|scalar|array|Pattern> $content
     */
    public function withPattern(array $content): self
    {
        $clone = clone $this;
        $clone->content = $content;

        return $clone;
    }

    public function build(): Body
    {
        $matchingRules = [];
        $content = self::extractMatchingRules($this->content, '$', $matchingRules);

        return Body::fromArray([
            'content' => \json_encode($content, \JSON_THROW_ON_ERROR),
            'matching_rules' => $matchingRules,
        ]);
    }

    /**
     * @param null|scalar|array<null|scalar|array> $value
     */
    public function like($value): Pattern\Like
    {
        return Pattern\Like::generateFromValue($value);
    }

    /**
     * @param null|scalar|array<null|scalar|array|Pattern>|Pattern $value
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
     * @param array<null|scalar|array|Pattern> $contents
     */
    private static function extractMatchingRules(array $contents, string $path, array &$matchingRules): array
    {
        foreach ($contents as $key => &$content) {
            if ($content instanceof Pattern) {
                $matchingRules[self::createPath($path, $key)] = [
                    'matchers' => [
                        $content->matcher()->toArray(),
                    ],
                ];
                $content = $content->generate();
            }

            if (\is_array($content)) {
                $content = self::extractMatchingRules($content, self::createPath($path, $key), $matchingRules);
            }
        }

        return $contents;
    }

    /**
     * @param int|string $key
     */
    private static function createPath(string $path, $key): string
    {
        if (\is_string($key)) {
            return \sprintf('%s.%s', $path, $key);
        }

        return \sprintf('%s[%s]', $path, $key);
    }
}
