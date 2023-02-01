<?php

declare(strict_types=1);

namespace App;

require_once '..\vendor\autoload.php';

echo 'Sample point: ';
$inputString = trim(readline());
if (!is_numeric($inputString)) {
    echo 'Sample point must be a number! Please enter other data';
    return;
}
$samplePoint = (float)$inputString;

$values = [0, 2, 1, 4];

/** @var CommonInterpolator[] $interpolators */
$interpolators =
    [
        new StepInterpolator($values),
        new LinearInterpolator($values),
        new LagrangeInterpolator($values),
        new NewtonInterpolator($values)
    ];

echo "Calculating value at sample point: {$samplePoint}\n";

foreach ($interpolators as $interpolator) {
    if ($interpolator instanceof CommonInterpolator) {
        $className = get_class($interpolator);
        $value = $interpolator->calculateValue($samplePoint);

        echo "Class {$className}: Interpolated value is {$value}\n";
    }
}
