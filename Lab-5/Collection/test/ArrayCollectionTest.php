<?php

use App\ArrayCollection;
use PHPUnit\Framework\TestCase;

class ArrayCollectionTest extends TestCase
{
    public function test_creating_emptyStringKey_exception()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Key cannot be an empty string');
        new ArrayCollection(['' => 1]);
    }

    public function test_map_multiplieTo2_allElemsMultiplieTo2()
    {
        $source = new ArrayCollection([1, 2, 3]);

        self::assertEquals([2, 4, 6], $source->map(function ($item) {
            return 2 * $item;
        })->toArray());
    }

    public function test_filter_isPositiveNumber_array23()
    {
        $source = new ArrayCollection([-1, 2, 3]);
        $isPositive = function ($item) {
            return $item > 0;
        };

        $resWithoutSavingKeys = $source->filter($isPositive);

        self::assertEquals($resWithoutSavingKeys->toArray(), [1 => 2, 2 => 3]);
    }

    public function test_count_array123_3()
    {
        $source = new ArrayCollection([1, 2, 3]);

        $sourceSize = $source->count();

        self::assertEquals($sourceSize, 3);
    }

    public function test_chunk_array1234_array12array23()
    {
        $source = new ArrayCollection([1, 2, 3, 4]);

        $chunkedSource = $source->chunk(2);

        self::assertEquals($chunkedSource->toArray(), [[1, 2], [3, 4]]);
    }

    public function test_fill_size4value3_array3333()
    {
        $source = new ArrayCollection([]);

        $filledSource = $source->fill(3, 4);

        self::assertEquals($filledSource->toArray(), [3, 3, 3, 3]);
    }

    public function test_intersect_ArrayCollection1234array02423_array234()
    {
        $source1 = new ArrayCollection([1, 2, 3, 4]);

        $overlaps = $source1->intersect([0, 2, 4, 2, 3]);

        self::assertEquals($overlaps->toArray(), [1 => 2, 2 => 3, 3 => 4]);
    }

    public function test_intersect_ArrayCollection1234ArrayCollection02427_array24()
    {
        $source1 = new ArrayCollection([1, 2, 3, 4]);
        $source2 = new ArrayCollection([0, 2, 4, 2, 7]);

        $overlaps = $source1->intersect($source2);

        self::assertEquals($overlaps->toArray(), [1 => 2, 2 => 4]);
    }

    public function test_intersect_ArrayCollection1234ArrayCollection02137array3771_array13()
    {
        $source1 = new ArrayCollection([1, 2, 3, 4]);
        $source2 = new ArrayCollection([0, 2, 1, 3, 7]);

        $overlaps = $source1->intersect($source2)->intersect([3, 7, 7, 1]);

        self::assertEquals($overlaps->toArray(), [2 => 1, 3 => 3]);
    }

    public function test_isKeyExists_key0_true()
    {
        $source1 = new ArrayCollection([1]);

        $isKeyExists = $source1->isKeyExist(0);

        self::assertEquals($isKeyExists, true);
    }

    public function test_isKeyExists_keyString_true()
    {
        $source1 = new ArrayCollection(['string' => 1]);

        $isKeyExists = $source1->isKeyExist('string');

        self::assertEquals($isKeyExists, true);
    }

    public function test_isKeyExists_nonExistentKey_false()
    {
        $source1 = new ArrayCollection(['string' => 1]);

        $isKeyExists = $source1->isKeyExist('test');

        self::assertEquals($isKeyExists, false);
    }

    public function test_isKeyExists_emptyStringKey_exception()
    {
        $source1 = new ArrayCollection([1]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Key cannot be an empty string');
        $source1->isKeyExist('');
    }

    public function test_diff_array123array157_array57()
    {
        $source1 = new ArrayCollection([1, 2, 3]);
        $source2 = [1, 5, 7];

        $diff = $source1->diff($source2);

        self::assertEquals($diff->toArray(), [1 => 2, 2 => 3]);
    }

    public function test_reduce_sumArray123_6()
    {
        $source = new ArrayCollection([1, 2, 3]);
        $sumFn = function ($carry, $item) {
            $carry += $item;
            return $carry;
        };

        $sum = $source->reduce($sumFn);

        self::assertEquals($sum, 6);
    }

    public function test_reverse_array123_array321()
    {
        $source = new ArrayCollection([1, 2, 3]);

        $sourceReverse = $source->reverse();

        self::assertEquals($sourceReverse->toArray(), [3, 2, 1]);
    }

    public function test_search_array1232search2_key1()
    {
        $source = new ArrayCollection([1, 2, 3, 2]);

        $keyOfSearchingEl = $source->search(2);

        self::assertEquals($keyOfSearchingEl, 1);
    }

    public function test_searchALL_array1232search2_array13()
    {
        $source = new ArrayCollection([1, 2, 3, 2]);

        $keysOfSearchingEl = $source->searchAll(2);

        self::assertEquals($keysOfSearchingEl, [1, 3]);
    }

    public function test_unique_array212323_array213()
    {
        $source = new ArrayCollection([2, 1, 2, 3, 2, 3]);

        $sourceUnique = $source->unique();

        self::assertEquals($sourceUnique->toArray(), [0 => 2, 1 => 1, 3 => 3]);
    }

    public function test_rsort_array132_array321()
    {
        $source = new ArrayCollection([1, 3, 2]);

        $source->rsort();

        self::assertEquals($source->toArray(), [3, 2, 1]);
    }

    public function test_sort_array132_array123()
    {
        $source = new ArrayCollection([1, 3, 2]);

        $source->sort(false);

        self::assertEquals($source->toArray(), [1, 2, 3]);
    }

    public function test_sort_saveKeysArray132_array123()
    {
        $source = new ArrayCollection(['one' => 1, 'three' => 3, 'two' => 2]);

        $source->sort(true);

        self::assertEquals($source->toArray(), ['one' => 1, 'two' => 2, 'three' => 3]);
    }

    public function test_slice_array1234slice2_array34()
    {
        $source = new ArrayCollection([1, 2, 3, 4]);

        $slicedSource = $source->slice(2);

        self::assertEquals($slicedSource->toArray(), [3, 4]);
    }

    public function test_inArray_array1234needle2_true()
    {
        $source = new ArrayCollection([1, 2, 3, 4]);

        $inArray = $source->contains(2);

        self::assertEquals($inArray, true);
    }

}
