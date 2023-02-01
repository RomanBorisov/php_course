<?php

declare(strict_types=1);

$f = function (float $x): float {
    return ($x * $x) - 2;
};

$a = 0.0;
$b = 2.0;
$eps = 0.0001;
$iterationsCount = 0;

function halfDivisionMethod(float $a, float $b, float $eps, $f, int &$iterationsCount): float
{
    $leftBorder = $a;
    $rightBorder = $b;
    $x = ($leftBorder + $rightBorder) / 2;

    while (abs($f($x)) >= $eps) {
        $x = ($leftBorder + $rightBorder) / 2;
        $iterationsCount++;
        if ($f($a) * $f($x) < 0) {
            $rightBorder = $x;
        } else {
            $leftBorder = $x;
        }
//        echo 'x: ' . $x . ', a: ' . $leftBorder . ', b: ' . $rightBorder . "\n";
    }

    return $x;
}

$y = halfDivisionMethod($a, $b, $eps, $f, $iterationsCount);

echo "Корень уравнения равен {$y}\n";
echo "Количество итераций равно " . $iterationsCount;
