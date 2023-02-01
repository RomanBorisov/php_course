<?php

declare(strict_types=1);

namespace App;


class LagrangeInterpolator extends CommonInterpolator
{
    public function calculateValue(float $x): float
    {
        $nmax = count($this->values) - 1;
        $lagrangePol = 0;
        $x0 = 0;

        if ($x >= $nmax) {
            return $this->values[$nmax];
        }

        if ($nmax <= 0) {
            return parent::calculateValue($x);
        }

        if ($x < 0) {
            return $this->values[0];
        }

        for ($i = 0; $i < $nmax; ++$i) {
            $basicsPol = 1;
            for ($j = 0; $j <= $nmax; ++$j) {
                if ($i !== $j) {
                    $basicsPol *= ($x - ($x0 + $j)) / (($x0 + $i) - ($x0 + $j));
                }
            }
            $lagrangePol += $basicsPol * $this->values[$i];
        }

        return $lagrangePol;
    }

}
