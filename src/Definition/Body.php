<?php

declare(strict_types=1);

namespace Oqq\Pact\Definition;

use Oqq\Pact\Util\Assert;

final class Body
{
    private array $content;
    private MatchingRules $matchingRules;

    public static function fromArray(array $payload): self
    {
        Assert::keyExists($payload, 'content');
        Assert::isArray($payload['content']);

        Assert::keyExists($payload, 'matching_rules');
        Assert::isArray($payload['matching_rules']);

        $matchingRules = MatchingRules::fromArray($payload['matching_rules']);

        return new self($payload['content'], $matchingRules);
    }

    public function toArray(): array
    {
        return [
            'content' => $this->content,
            'matching_rules' => $this->matchingRules->toArray(),
        ];
    }

    public function content(): array
    {
        return $this->content;
    }

    public function matchingRules(): MatchingRules
    {
        return $this->matchingRules;
    }

    private function __construct(array $content, MatchingRules $matchingRules)
    {
        $this->content = $content;
        $this->matchingRules = $matchingRules;
    }
}
