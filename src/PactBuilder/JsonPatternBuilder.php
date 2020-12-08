<?php

declare(strict_types=1);

namespace Oqq\Pact\PactBuilder;

use Oqq\Pact\Definition\Body;

final class JsonPatternBuilder
{
    private array $content = [];

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

    public function term(string $value, string $pattern): Term
    {
        return Term::generateWithPattern($value, $pattern);
    }

    private static function extractMatchingRules(array $contents, string $path, array &$matchingRules): array
    {
        foreach ($contents as $key => &$content) {
            if (\is_array($content)) {
                $content = self::extractMatchingRules($content, self::createPath($path, $key), $matchingRules);
                continue;
            }

            if ($content instanceof Term) {
                $matchingRules[self::createPath($path, $key)] = [
                    'matchers' => [
                        [
                            'type' => 'regex',
                            'pattern' => $content->pattern(),
                        ],
                    ],
                ];
                $content = $content->generate();
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
