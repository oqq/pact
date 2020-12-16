<?php

declare(strict_types=1);

namespace Oqq\Pact\Generator;

use Oqq\Pact\Definition\Matcher;
use Oqq\Pact\Definition\MatchingRule;
use Oqq\Pact\Definition\MatchingRules;
use Oqq\Pact\Definition\Message;
use Oqq\Pact\Definition\MessagePact;
use Oqq\Pact\Definition\Messages;
use Oqq\Pact\Exception\RuntimeException;

final class PactFileGenerator
{
    public function generateMessagePact(Specification $specification, MessagePact $pact): array
    {
        if ($specification->version() !== '3.0.0') {
            throw new RuntimeException(
                \sprintf(
                    'Could not generate for version "%s"',
                    $specification->version(),
                )
            );
        }

        return [
            'consumer' => $pact->consumer()->toArray(),
            'provider' => $pact->provider()->toArray(),
            'messages' => \iterator_to_array($this->generateMessagesContent($pact->messages())),
            'metadata' => [
                'pactSpecification' => $specification->toArray(),
            ],
        ];
    }

    private function generateMessagesContent(Messages $messages): \Generator
    {
        /** @var Message $message */
        foreach ($messages as $message) {
            yield [
                'description' => $message->description()->value(),
                'providerStates' => [],
                'contents' => $message->body()->content(),
                'metaData' => $message->metadata(),
                'matchingRules' => [
                    'body' => \iterator_to_array($this->patchMatchingRules($message->body()->matchingRules())),
                ],
            ];
        }
    }

    private function patchMatchingRules(MatchingRules $matchingRules): \Generator
    {
        /** @var MatchingRule $matchingRule */
        foreach ($matchingRules as $path => $matchingRule) {
            yield $path => $this->pathMatchingRule($matchingRule);
        }
    }

    private function pathMatchingRule(MatchingRule $matchingRule): array
    {
        return [
            'combine' => $matchingRule->combine(),
            'matchers' => \array_map(
                fn (Matcher $matcher): array => $this->patchMatcher($matcher),
                $matchingRule->matchers()
            ),
        ];
    }

    private function patchMatcher(Matcher $matcher): array
    {
        if ($matcher instanceof Matcher\Collection) {
            return ['min' => $matcher->min()];
        }

        if ($matcher instanceof Matcher\Regex) {
            return ['match' => $matcher->type(), 'regex' => $matcher->pattern()];
        }

        if ($matcher instanceof Matcher\Include_) {
            return ['match' => $matcher->type(), 'include' => $matcher->value()];
        }

        return ['match' => $matcher->type()];
    }
}
