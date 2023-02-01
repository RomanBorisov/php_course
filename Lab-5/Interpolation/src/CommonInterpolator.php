<?php

declare(strict_types=1);

namespace App;


class CommonInterpolator
{
    /**
     * @var float[]
     */
    protected array $values;

    public function __construct(array $values)
    {
        $this->values = $values;
    }

    public function calculateValue(float $x): float
    {
        return 0;
    }

    /**
     * @return float[]
     */
    protected function getValues(): array
    {
        return $this->values;
    }
}
