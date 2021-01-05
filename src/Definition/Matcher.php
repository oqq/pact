<?php

declare(strict_types=1);

namespace Oqq\Pact\Definition;

use Oqq\Pact\Util\Assert;

abstract class Matcher
{
    /** @var array<string, class-string<Matcher>> */
    private const MATCHER_TYPES = [
        Matcher\Collection::MATCH_TYPE => Matcher\Collection::class,
        Matcher\Decimal::MATCH_TYPE => Matcher\Decimal::class,
        Matcher\Equality::MATCH_TYPE => Matcher\Equality::class,
        Matcher\Include_::MATCH_TYPE => Matcher\Include_::class,
        Matcher\Integer::MATCH_TYPE => Matcher\Integer::class,
        Matcher\Null_::MATCH_TYPE => Matcher\Null_::class,
        Matcher\Regex::MATCH_TYPE => Matcher\Regex::class,
        Matcher\Type::MATCH_TYPE => Matcher\Type::class,
    ];

    public static function create(array $payload): self
    {
        Assert::keyExists($payload, 'type');
        Assert::oneOf($payload['type'], \array_keys(self::MATCHER_TYPES));

        /** @var array&array{type: key-of<self::MATCHER_TYPES>} $payload */
        $type = $payload['type'];
        $matcher = self::MATCHER_TYPES[$type];

        return $matcher::fromArray($payload);
    }

    /**
     * @param array&array{type: key-of<self::MATCHER_TYPES>} $payload
     */
    abstract public static function fromArray(array $payload): self;

    /**
     * @return array&array{type: key-of<self::MATCHER_TYPES>}
     */
    abstract public function toArray(): array;

    /**
     * @return key-of<self::MATCHER_TYPES>
     */
    abstract public function type(): string;
}
