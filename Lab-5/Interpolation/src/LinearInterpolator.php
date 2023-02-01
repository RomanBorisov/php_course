<?php

declare(strict_types=1);

namespace App;


class LinearInterpolator extends CommonInterpolator
{
    public function calculateValue(float $x): float
    {
        $nmax = count($this->values) - 1;

        if ($nmax < 0) {
            return parent::calculateValue($x);
        }

        if ($x < 0) {
            return $this->values[0];
        }

        $n = (int)$x;

        return ($n >= $nmax)
            ? $this->values[$nmax]
            : ($this->values[$n] + ($this->values[$n + 1] - $this->values[$n]) * ($x - $n));
    }
}
