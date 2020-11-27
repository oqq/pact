<?php

declare(strict_types=1);

namespace Oqq\Pact\Definition;

use Oqq\Pact\Util\Assert;

final class Description
{
    private string $value;

    public static function fromString(string $value): self
    {
        Assert::notEmpty($value);

        return new self($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    private function __construct(string $value)
    {
        $this->value = $value;
    }
}
