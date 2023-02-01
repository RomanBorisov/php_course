<?php

use App\Math\HalfDivisionMethod;
use PHPUnit\Framework\TestCase;

class HalfDivisionMethodTest extends TestCase
{
    public function test_halfDivisionMethod_bordersAreEqual_isNull()
    {
        $i = 0;
        $hlfDivMeth = new HalfDivisionMethod();
        $f = function (float $x): float {
            return ($x * $x) - 2;
        };
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Borders are equal');
        $hlfDivMeth->halfDivisionMethod(0, 0, 0.01, $f, $i);
    }

    public function test_halfDivisionMethod_rightBorderLessThenLeft_isNull()
    {
        $i = 0;
        $hlfDivMeth = new HalfDivisionMethod();
        $f = function (float $x): float {
            return ($x * $x) - 2;
        };

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Right border cannot be less than right');
        $hlfDivMeth->halfDivisionMethod(4, 3, 0.01, $f, $i);
    }

    public function test_halfDivisionMethod_correctBorders_isFloat()
    {
        $i = 0;
        $hlfDivMeth = new HalfDivisionMethod();
        $f = function (float $x): float {
            return $x * $x - 2;
        };

        $this->assertEquals(1.4140625, $hlfDivMeth->halfDivisionMethod(0, 2, 0.01, $f, $i));
    }

    public function test_halfDivisionMethod_twoSolveOnSegment_isFirstRoot()
    {
        $i = 0;
        $hlfDivMeth = new HalfDivisionMethod();
        $f = function (float $x): float {
            return $x * $x - 2;
        };

        $this->assertEquals(-1.4140625, $hlfDivMeth->halfDivisionMethod(-2, 2, 0.01, $f, $i));
    }

    public function test_halfDivisionMethod_noSolveOnSegment_isNull()
    {
        $i = 0;
        $hlfDivMeth = new HalfDivisionMethod();
        $f = function (float $x): float {
            return $x * $x - 2;
        };


        $this->expectException(Exception::class);
        $this->expectExceptionMessage('There is no solve on this range');
        $hlfDivMeth->halfDivisionMethod(20, 30, 0.01, $f, $i);
    }


}
