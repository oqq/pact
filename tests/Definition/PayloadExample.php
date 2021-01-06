<?php

declare(strict_types=1);

namespace Oqq\PactTest\Definition;

final class PayloadExample
{
    private function __construct() {}

    public static function matchingRule(): array
    {
        return [
            'matchers' => [
                ['match' => 'type'],
            ],
        ];
    }

    public static function status(): int
    {
        return 200;
    }

    public static function method(): string
    {
        return 'GET';
    }

    public static function path(): array
    {
        return [
            'value' => '/',
            'matching_rule' => [
                'matchers' => [
                    ['match' => 'include', 'value' => '/'],
                ],
            ],
        ];
    }

    public static function query(): array
    {
        return [
            'terms' => self::queryParam(),
        ];
    }

    public static function queryParam(): array
    {
        return [
            'values' => ['x', 'y'],
            'matching_rule' => [
                'matchers' => [
                    ['match' => 'equality'],
                ],
            ],
        ];
    }

    public static function headers(): array
    {
        return [
            'Content-Type' => [
                'value' => 'application/json;charset=UTF-8',
                'matching_rule' => [
                    'matchers' => [
                        ['match' => 'include', 'value' => 'application/json'],
                    ],
                ],
            ],
        ];
    }

    public static function body(): array
    {
        return [
            'content' => '{"some_json_value": true}',
            'matching_rules' => [
                '$.some_json_value' => [
                    'matchers' => [
                        ['match' => 'type'],
                    ],
                ],
            ],
        ];
    }

    public static function description(): string
    {
        return 'test';
    }

    public static function providerStates(): array
    {
        return [
            self::providerState(),
        ];
    }

    public static function providerState(): array
    {
        return [
            'name' => 'test',
            'params' => [],
        ];
    }

    public static function consumerRequest(): array
    {
        return [
            'method' =>  self::method(),
            'path' => self::path(),
            'query' => self::query(),
            'headers' => self::headers(),
            'body' => self::body(),
        ];
    }

    public static function providerResponse(): array
    {
        return [
            'status' => self::status(),
            'headers' => self::headers(),
            'body' => self::body(),
        ];
    }

    public static function interaction(): array
    {
        return [
            'description' => self::description(),
            'provider_states' => self::providerStates(),
            'consumer_request' => self::consumerRequest(),
            'provider_response' => self::providerResponse(),
        ];
    }

    public static function interactions(): array
    {
        return [
            self::interaction(),
        ];
    }

    public static function consumer(): array
    {
        return [
            'name' => 'consumer',
        ];
    }

    public static function provider(): array
    {
        return [
            'name' => 'provider',
        ];
    }

    public static function message(): array
    {
        return [
            'description' => self::description(),
            'provider_states' => self::providerStates(),
            'body' => [
                'content' => '{"some": "value"}',
                'matching_rules' => [],
            ],
            'metadata' => ['some' => 'value'],
        ];
    }

    public static function messages(): array
    {
        return [
            self::message(),
        ];
    }

    public static function messagePact(): array
    {
        return [
            'consumer' => self::consumer(),
            'provider' => self::provider(),
            'messages' => self::messages(),
        ];
    }
}
