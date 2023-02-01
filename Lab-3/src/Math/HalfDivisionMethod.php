<?php

namespace App\Math;

use Exception;

class HalfDivisionMethod
{
    public function halfDivisionMethod(float $a, float $b, float $eps, callable $f, int &$iterationsCount): ?float
    {
        if ($a === $b) {
            throw new Exception('Borders are equal');
        }

        if ($a > $b) {
            throw new Exception('Right border cannot be less than right');
        }

        $maxIterations = 1000;
        $leftBorder = $a;
        $rightBorder = $b;
        $x = ($leftBorder + $rightBorder) / 2;

        while (abs($f($x)) >= $eps) {
            $x = ($leftBorder + $rightBorder) / 2;
            $iterationsCount++;
            if ($iterationsCount > $maxIterations) {
                throw new Exception('There is no solve on this range');
            }
            if ($f($a) * $f($x) < 0) {
                $rightBorder = $x;
            } else {
                $leftBorder = $x;
            }
//            echo 'x: ' . $x . ', a: ' . $leftBorder . ', b: ' . $rightBorder . "\n";
        }

        return $x;
    }
}
