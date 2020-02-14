<?php

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{

    public function testAsort()
    {
        $vegetablesArray = [
            'carrot' => 1,
            'broccoli' => 2.99,
            'garlic' => 3.98,
            'swede' => 1.75
        ];

        $sortedArray = [
            'carrot' => 1,
            'swede' => 1.75,
            'broccoli' => 2.99,
            'garlic' => 3.98
        ];

        asort($vegetablesArray, SORT_NUMERIC);

        $this->assertSame($sortedArray, $vegetablesArray);
    }

    public function testKsort()
    {
        $fruitsArray = [
            'oranges' => 1.75,
            'apples' => 2.05,
            'bananas' => 0.68,
            'pears' => 2.75
        ];

        $sortedArray = [
            'apples' => 2.05,
            'bananas' => 0.68,
            'oranges' => 1.75,
            'pears' => 2.75
        ];

        ksort($fruitsArray, SORT_STRING);

        $this->assertSame($fruitsArray, $sortedArray);
    }
}
