<?php

declare(strict_types=1);

namespace Oqq\Pact\Definition;

use Oqq\Pact\Util\Assert;

final class MatchingRule
{
    private const COMBINE_TYPE_AND = 'AND';
    private const COMBINE_TYPE_OR = 'OR';

    private const DEFAULT_COMBINE_TYPE = self::COMBINE_TYPE_AND;

    /** @var array<self::COMBINE_TYPE_*> */
    private const COMBINE_TYPES = [
        self::COMBINE_TYPE_AND,
        self::COMBINE_TYPE_OR,
    ];

    /** @var self::COMBINE_TYPE_* */
    private string $combine;

    /** @var list<Matcher> */
    private array $matchers;

    public static function fromArray(array $payload): self
    {
        $combine = self::DEFAULT_COMBINE_TYPE;

        if (\array_key_exists('combine', $payload)) {
            Assert::oneOf($payload['combine'], self::COMBINE_TYPES);

            /** @var value-of<self::COMBINE_TYPES> $combine */
            $combine = $payload['combine'];
        }

        Assert::keyExists($payload, 'matchers');
        Assert::isList($payload['matchers']);
        Assert::allIsArray($payload['matchers']);

        $matchers = \array_map(
            static fn (array $matcher): Matcher => Matcher::create($matcher),
            $payload['matchers']
        );

        return new self($combine, ...$matchers);
    }

    public function toArray(): array
    {
        return [
            'combine' => $this->combine,
            'matchers' => \array_map(
                static fn (Matcher $matcher): array => $matcher->toArray(),
                $this->matchers
            ),
        ];
    }

    public function combine(): string
    {
        return $this->combine;
    }

    /**
     * @return list<Matcher>
     */
    public function matchers(): array
    {
        return $this->matchers;
    }

    /**
     * @param self::COMBINE_TYPE_* $combine
     */
    private function __construct(string $combine, Matcher ...$matchers)
    {
        $this->combine = $combine;
        $this->matchers = $matchers;
    }
}
