<?php

declare(strict_types=1);

namespace Oqq\Pact\Definition;

use Oqq\Pact\Util\Assert;

final class Status
{
    private int $value;

    public static function fromInteger(int $value): self
    {
        Assert::range($value, 100, 599);

        return new self($value);
    }

    public function value(): int
    {
        return $this->value;
    }

    private function __construct(int $value)
    {
        $this->value = $value;
    }
}
