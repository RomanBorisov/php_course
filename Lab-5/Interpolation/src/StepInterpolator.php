<?php

declare(strict_types=1);

namespace App;


class StepInterpolator extends CommonInterpolator
{
    public function calculateValue(float $x): float
    {
        if (count($this->values) > 0) {
            return $this->values[$this->getSafeIndex((int)round($x))];
        }

        return parent::calculateValue($x);
    }

    private function getSafeIndex(int $index): int
    {
        if ($index < 0) {
            return 0;
        }

        if ($index > (count($this->values) - 1)) {
            return count($this->values) - 1;
        }

        return $index;
    }
}
