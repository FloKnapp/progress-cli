<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use ProgressCli\Progress;

/**
 * Class ProgressTest
 *
 * @author Florian Knapp <florian.knapp@check24.de>
 */
class ProgressTest extends TestCase
{

    /**
     * Dummy dataset with 140 entries
     * @return array
     */
    public function dummyDataset()
    {
        $data = [];

        for($i = 0; $i < 140; $i++) {
            $data[] = 'empty';
        }

        return [
            [$data]
        ];
    }

    /**
     * Test constructor call with custom params
     */
    public function testSetConstructorParams()
    {
        $progress = new Progress(140, 60);

        self::assertSame(140, $progress->getTotal());
        self::assertSame(60, $progress->getChars());
    }

    /**
     * Test constructor call with array param
     * @dataProvider dummyDataset
     */
    public function testSetConstructorArrayParams($data)
    {
        $progress = new Progress($data, 60);

        self::assertSame(140, $progress->getTotal());
        self::assertSame(60, $progress->getChars());
    }

    /**
     * Test constructor call with default params
     */
    public function testSetConstructorDefaultParams()
    {
        $progress = new Progress(140);

        self::assertSame(140, $progress->getTotal());
        self::assertSame(40, $progress->getChars());
    }

    /**
     * Test constructor call with missing parameter
     * @expectedException \InvalidArgumentException
     */
    public function testUndefinedTotalAmountConstructor()
    {
        $progress = new Progress();

        for ($i = 0; $i < 140; $i++) {
            $progress->update($i);
        }
    }

}
