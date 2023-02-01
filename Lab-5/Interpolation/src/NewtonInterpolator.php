<?php

declare(strict_types=1);

namespace App;


class NewtonInterpolator extends CommonInterpolator
{
    public function calculateValue(float $x): float
    {
        $nmax = count($this->values) - 1;
        $res = $this->values[0];

        if ($nmax <= 0) {
            return parent::calculateValue($x);
        }

        if ($x < 0) {
            return $this->values[0];
        }

        for ($i = 1; $i <= $nmax; $i++) {
            $F = 0;
            for ($j = 0; $j <= $i; $j++) {
                $D = 1;
                for ($k = 0; $k <= $i; $k++) {
                    if ($k != $j) {
                        $D *= ($j - $k);
                    }
                }
                $F += $this->values[$j] / $D;
            }

            for ($k = 0; $k < $i; $k++) {
                $F *= ($x - $k);
            }

            $res += $F;
        }

        return $res;
    }
}
