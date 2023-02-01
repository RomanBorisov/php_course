<?php

declare(strict_types=1);

namespace App;

use ArrayAccess;
use ArrayIterator;
use Countable;
use Exception;
use IteratorAggregate;

class ArrayCollection implements IteratorAggregate, ArrayAccess, Countable
{
    private $container = [];

    public function __construct(array $item = [])
    {
        if (array_key_exists('', $item)) {
            throw new Exception('Key cannot be an empty string');
        }
        $this->container = $item;
    }

    public function toArray(): array
    {
        return $this->container;
    }

    public function count(): int
    {
        return count($this->container);
    }

    public function map(callable $callback): ArrayCollection
    {
        $this->container = array_map($callback, $this->container);
        return $this;
    }

    public function filter(callable $callback, string $passedParams = Filter::VALUE): ArrayCollection
    {
        if ($passedParams === Filter::VALUE) {
            $this->container = array_filter($this->container, $callback, 0);
        } elseif ($passedParams === Filter::BOTH) {
            $this->container = array_filter($this->container, $callback, ARRAY_FILTER_USE_BOTH);
        } elseif ($passedParams === Filter::KEY) {
            $this->container = array_filter($this->container, $callback, ARRAY_FILTER_USE_KEY);
        }
        return $this;
    }

    public function chunk(int $size, bool $preserveKeys = false): ArrayCollection
    {
        $this->container = array_chunk($this->container, $size, $preserveKeys);
        return $this;

    }

    /**
     * @param int|string|null $startKey
     */
    public function fill(int $value, int $count, $startKey = 0): ArrayCollection
    {
        $this->checkForEmptyStringKey($startKey);

        for ($i = $startKey; $i <= $count - 1; $i++) {
            $this->container[] = $value;
        }
        return $this;
    }

    /**
     * Keys of collection has higher priority than keys of array
     */
    public function intersect(iterable ...$collections): ArrayCollection
    {
        foreach ($collections as $collection) {
            $result = [];

            if (is_array($collection)) {
                $result = array_intersect($this->container, $collection);
            } else {
                foreach ($collection as $key => $item) {
                    if (in_array($item, $this->container) && !in_array($item, $result)) {
                        $result[$key] = $item;
                    }
                }
            }
            $this->container = $result;
        }
        return $this;
    }

    /**
     * @param int|string|null $key
     */
    public function isKeyExist($key): bool
    {
        $this->checkForEmptyStringKey($key);

        return array_key_exists($key, $this->container);
    }

    public function diff(array ...$arrays): ArrayCollection
    {
        $this->container = array_diff($this->container, ...$arrays);
        return $this;
    }

    /**
     * @return mixed
     */
    public function randKey(int $num = 1)
    {
        return array_rand($this->container, $num);
    }

    /**
     * @return mixed
     */
    public function randElem(int $num = 1)
    {
        if ($num === 1) {
            return $this->container[array_rand($this->container, $num)];
        }
        $result = [];
        foreach (array_rand($this->container, $num) as $item) {
            $result[$item] = $this->container[$item];
        }
        return $result;
    }

    public function print(): ArrayCollection
    {
        print_r($this->container);
        echo "\n";
        return $this;
    }

    public function printAsString(): ArrayCollection
    {
        foreach ($this->container as $key => $val) {
            echo $key . ":" . $val . "\n";
        }
        echo "\n";
        return $this;
    }

    public function reduce(callable $callback, $initial = NULL)
    {
        return array_reduce($this->container, $callback, $initial);
    }

    public function reverse(bool $preserveKeys = false): ArrayCollection
    {
        $this->container = array_reverse($this->container, $preserveKeys);
        return $this;
    }

    public function search($needle)
    {
        return array_search($needle, $this->container, true);
    }

    public function searchAll($needle): array
    {
        $result = [];
        foreach ($this->container as $key => $item) {
            if ($item === $needle) {
                $result[] = $key;
                continue;
            }
        }

        return $result;
    }

    public function unique(int $sortFlags = SORT_STRING): ArrayCollection
    {
        $this->container = array_unique($this->container, $sortFlags);
        return $this;
    }

    public function rsort(bool $saveKeys = false, $sortFlags = SORT_REGULAR): ArrayCollection
    {
        if ($saveKeys) {
            arsort($this->container, $sortFlags);
            return $this;
        }
        rsort($this->container, $sortFlags);
        return $this;
    }

    public function sort(bool $saveKeys = true, int $sortFlags = SORT_REGULAR): ArrayCollection
    {
        if ($saveKeys) {
            asort($this->container, $sortFlags);
            return $this;
        }
        sort($this->container, $sortFlags);
        return $this;
    }

    public function slice(int $offset, int $length = null, bool $preserveKeys = false): ArrayCollection
    {
        $this->container = array_slice($this->container, $offset, $length, $preserveKeys);
        return $this;
    }

    public function contains($needle, bool $strict = false): bool
    {
        return in_array($needle, $this->container, $strict);
    }

    public function containsLeastOne(callable $callback, string $passedParams = "value"): bool
    {
        $temp = $this;
        $temp->filter($callback, $passedParams);
        return $temp->isEmpty();
    }

    public function sortBy(callable $callback, bool $saveKeys = true): ArrayCollection
    {
        if ($saveKeys) {
            uasort($this->container, function ($a, $b) use ($callback) {
                return strcmp($callback($a), $callback($b));
            });
            return $this;
        }

        usort($this->container, function ($a, $b) use ($callback) {
            return strcmp($callback($a), $callback($b));
        });
        return $this;
    }

    public function skip(int $offset, bool $saveKeys = true): ArrayCollection
    {
        $this->container = array_slice($this->container, $offset, null, $saveKeys);
        return $this;
    }

    public function take(int $length, bool $saveKeys = true): ArrayCollection
    {
        $this->container = array_slice($this->container, 0, $length, $saveKeys);
        return $this;
    }

    public function push($item, $key = null): ArrayCollection
    {
        $this->checkForEmptyStringKey($key);
        if ($key === null) {
            $this->container[] = $item;
        } else {
            $this->container[$key] = $item;
        }

        return $this;
    }

    public function groupBy(callable $callback): ArrayCollection
    {
        $result = new ArrayCollection([]);

        foreach ($this->container as $item) {
            $key = $callback($item);

            if ($result[$key] === null) {
                $result[$key] = new ArrayCollection([$item]);
            } else {
                $result[$key][] = $item;
            }
        }
        return $result;
    }

    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->container);
    }

    public function offsetExists($offset): bool
    {
        return $this->isKeyExist($offset);
    }

    public function offsetGet($offset)
    {
        $this->checkForEmptyStringKey($offset);
        return $this->container[$offset] ?? null;
    }

    public function offsetSet($offset, $value): void
    {
        $this->push($value, $offset);
    }

    public function offsetUnset($offset): void
    {
        unset($this->container[$offset]);
    }

    private function isEmptyString($item): bool
    {
        return is_string($item) && strlen($item) === 0;
    }

    private function checkForEmptyStringKey($item): void
    {
        if ($this->isEmptyString($item)) {
            throw new Exception('Key cannot be an empty string');
        }
    }

}
