<?php

declare(strict_types=1);

namespace Oqq\PactTest\Generator;

use Oqq\Pact\Definition\MessagePact;
use Oqq\Pact\Exception\RuntimeException;
use Oqq\Pact\Generator\PactFileGenerator;
use Oqq\Pact\Generator\Specification;
use Oqq\PactTest\Definition\PayloadExample;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Oqq\Pact\Generator\PactFileGenerator
 */
final class PactFileGeneratorTest extends TestCase
{
    private PactFileGenerator $generator;

    public function setUp(): void
    {
        parent::setUp();

        $this->generator = new PactFileGenerator();
    }

    public function testItThrowsWithUnsupportedVersionMessagePactGenerate(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectDeprecationMessage('Could not generate for version "4.0.0"');

        $this->generator->generateMessagePact(
            Specification::fromArray(['version' => '4.0.0']),
            MessagePact::fromArray(PayloadExample::messagePact())
        );
    }

    public function testItGeneratesMessagePactFile(): void
    {
        $specification = Specification::fromArray([
            'version' => '3.0.0',
        ]);

        $pact = MessagePact::fromArray([
             'consumer' => [
                 'name' => 'test-consumer',
             ],
            'provider' => [
                'name' => 'test-provider',
            ],
            'messages' => [
                [
                    'description' => 'test alpha',
                    'provider_states' => [],
                    'body' => [
                        'content' => '{"some": "value}',
                        'matching_rules' => [
                            '$.some' => [
                                'matchers' => [
                                    ['type' => 'regex', 'pattern' => '/[a-z]+/'],
                                    ['type' => 'include', 'value' => 'val'],
                                ],
                            ],
                        ],
                    ],
                    'metadata' => [],
                ],
                [
                    'description' => 'test beta',
                    'provider_states' => [],
                    'body' => [
                        'content' => '{"some": "value}',
                        'matching_rules' => [
                            '$.some' => [
                                'matchers' => [
                                    ['type' => 'type'],
                                ],
                            ],
                        ],
                    ],
                    'metadata' => [],
                ],
            ],
        ]);

        $pactFileValues = $this->generator->generateMessagePact($specification, $pact);

        Assert::assertSame([

            'consumer' => [
                'name' => 'test-consumer',
            ],
           'provider' => [
               'name' => 'test-provider',
           ],
           'messages' => [
               [
                   'description' => 'test alpha',
                   'providerStates' => [],
                   'contents' => '{"some": "value}',
                   'metaData' => [],
                   'matchingRules' => [
                       'body' => [
                           '$.some' => [
                               'combine' => 'AND',
                               'matchers' => [
                                   ['match' => 'regex', 'regex' => '/[a-z]+/'],
                                   ['match' => 'include', 'include' => 'val'],
                               ],
                           ],
                       ],
                   ],
               ],
               [
                   'description' => 'test beta',
                   'providerStates' => [],
                   'contents' => '{"some": "value}',
                   'metaData' => [],
                   'matchingRules' => [
                       'body' => [
                           '$.some' => [
                               'combine' => 'AND',
                               'matchers' => [
                                   ['match' => 'type'],
                               ],
                           ],
                       ],
                   ],
               ],
           ],
           'metadata' => [
                'pactSpecification' => [
                    'version' => '3.0.0',
                ],
           ],
        ], $pactFileValues);
    }
}
