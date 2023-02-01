<?php
declare(strict_types=1);

const EPSILON = 0.000000000001;

echo "Please set the quadratic equation\n";
$a = (float)readline("a: ");
$b = (float)readline("b: ");
$c = (float)readline("c: ");

$determinant = pow($b, 2.0) - 4.0 * $a * $c;

if (isEqual($a, 0.0) && !isEqual($b, 0.0)) {
    $x = -$c / $b;
    echo "The root is {$x}";
} elseif (isEqual($a, 0.0) && isEqual($b, 0.0) && isEqual($c, 0.0)) {
    echo 'The entered data is incorrect!';
} else {
    if ($determinant < 0.0) {
        echo 'Determinant < 0. Solve is not exist!';
    } elseif (isEqual($determinant, 0.0)) {
        $x = -$b / (2.0 * $a);
        echo "The root is {$x}";
    } else {
        $x1 = (-$b + sqrt($determinant)) / (2.0 * $a);
        $x2 = (-$b - sqrt($determinant)) / (2.0 * $a);
        echo "The roots are {$x1} and {$x2}";
    }
}

function isEqual($a, $b)
{
    if (abs($a - $b) < EPSILON) {
        return true;
    }
    return false;
}
