<?php

declare(strict_types=1);

namespace Oqq\PactTest;

use Oqq\Pact\Exception\InvalidArgumentException;

final class ValueObjectPayloadAssertion
{
    private function __construct() {}

    /**
     * @return iterable<array-key, array{0: \Exception, 1: array}>
     */
    public static function string(array $perfectValues, string $key): iterable
    {
        yield 'missing value for ' . $key => [
            new InvalidArgumentException('Expected the key "' . $key . '" to exist'),
            self::removeKey($perfectValues, $key),
        ];

        yield 'invalid type for ' . $key => [
            new InvalidArgumentException('Expected a string. Got: integer'),
            self::replaceKey($perfectValues, $key, 5),
        ];
    }

    /**
     * @return iterable<array-key, array{0: \Exception, 1: array}>
     */
    public static function integer(array $perfectValues, string $key): iterable
    {
        yield 'missing value for ' . $key => [
            new InvalidArgumentException('Expected the key "' . $key . '" to exist'),
            self::removeKey($perfectValues, $key),
        ];

        yield 'invalid type for ' . $key => [
            new InvalidArgumentException('Expected an integer. Got: string'),
            self::replaceKey($perfectValues, $key, '5'),
        ];
    }

    /**
     * @return iterable<array-key, array{0: \Exception, 1: array}>
     */
    public static function array(array $perfectValues, string $key): iterable
    {
        yield 'missing value for ' . $key => [
            new InvalidArgumentException('Expected the key "' . $key . '" to exist'),
            self::removeKey($perfectValues, $key),
        ];

        yield 'invalid type for ' . $key . ' value' => [
            new InvalidArgumentException('Expected an array. Got: integer'),
            self::replaceKey($perfectValues, $key, 5),
        ];
    }

    /**
     * @return iterable<array-key, array{0: \Exception, 1: array}>
     */
    public static function stringList(array $perfectValues, string $key): iterable
    {
        yield 'missing value for ' . $key => [
            new InvalidArgumentException('Expected the key "' . $key . '" to exist'),
            self::removeKey($perfectValues, $key),
        ];

        yield 'invalid type for ' . $key => [
            new InvalidArgumentException('Expected list - non-associative array'),
            self::replaceKey($perfectValues, $key, ['alpha' => 1]),
        ];

        yield 'invalid type for ' . $key . ' value' => [
            new InvalidArgumentException('Expected a string. Got: integer'),
            self::replaceKey($perfectValues, $key, [5]),
        ];
    }

    /**
     * @return iterable<array-key, array{0: \Exception, 1: array}>
     */
    public static function arrayList(array $perfectValues, string $key): iterable
    {
        yield 'missing value for ' . $key => [
            new InvalidArgumentException('Expected the key "' . $key . '" to exist'),
            self::removeKey($perfectValues, $key),
        ];

        yield 'invalid type for ' . $key => [
            new InvalidArgumentException('Expected list - non-associative array'),
            self::replaceKey($perfectValues, $key, ['alpha' => 1]),
        ];

        yield 'invalid type for ' . $key . ' value' => [
            new InvalidArgumentException('Expected an array. Got: integer'),
            self::replaceKey($perfectValues, $key, [5]),
        ];
    }

    /**
     * @return iterable<array-key, array{0: \Exception, 1: array}>
     */
    public static function map(array $perfectValues, string $key): iterable
    {
        yield 'missing value for ' . $key => [
            new InvalidArgumentException('Expected the key "' . $key . '" to exist'),
            self::removeKey($perfectValues, $key),
        ];

        yield 'invalid type for ' . $key => [
            new InvalidArgumentException('Expected map - associative array'),
            self::replaceKey($perfectValues, $key, [5]),
        ];
    }

    private static function removeKey(array $values, string $key): array
    {
        return \array_diff_key($values, [$key => true]);
    }

    /**
     * @param mixed $newValue
     */
    private static function replaceKey(array $values, string $key, $newValue): array
    {
        return \array_merge($values, [$key => $newValue]);
    }
}
