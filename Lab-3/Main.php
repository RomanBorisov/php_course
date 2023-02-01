<?php

declare(strict_types=1);

use App\Math\HalfDivisionMethod;

require_once "vendor/autoload.php";


$a = 0.0;
$b = 0.0;
$eps = 0.01;
$iterationsCount = 0;
$halfDivisionMethod = new HalfDivisionMethod();
$f = function (float $x): float {
    return $x * $x - 2;
};

try {
    $y = $halfDivisionMethod->halfDivisionMethod($a, $b, $eps, $f, $iterationsCount);
} catch (Exception $e) {
    echo 'Exception: ', $e->getMessage(), "\nPlease enter other range.";
    return;
}

echo "Корень уравнения равен {$y}\n";
echo "Количество итераций равно " . $iterationsCount;
