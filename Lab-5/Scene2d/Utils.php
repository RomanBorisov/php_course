<?php

declare(strict_types=1);

namespace Scene2d;

use Traversable;

class Utils
{
    public static function minBy(Traversable $traversable, callable $accessor): object
    {
        $minFieldValue = null;
        $minItem = null;
        foreach ($traversable as $item) {
            $fieldValue = $accessor($item);
            if ($minFieldValue === null || $accessor($item) < $minFieldValue) {
                $minFieldValue = $fieldValue;
                $minItem = $item;
            }
        }

        return $minItem;
    }

    public static function maxBy(Traversable $traversable, callable $accessor): object
    {
        $maxFieldValue = null;
        $maxItem = null;
        foreach ($traversable as $item) {
            $fieldValue = $accessor($item);
            if ($maxFieldValue === null || $accessor($item) > $maxFieldValue) {
                $maxFieldValue = $fieldValue;
                $maxItem = $item;
            }
        }

        return $maxItem;
    }
}
