<?php

use PHPUnit\Framework\TestCase;

require_once('src/SpiralMemory.php');

class SpiralMemoryTest extends TestCase {
    public function testCase1()
    {
        $o = new SpiralMemory();
        $o->buildUntilSquare(1);
        $this->assertEquals(0, $o->getManhattanDistance());
    }
    public function testCase2()
    {
        $o = new SpiralMemory();
        $o->buildUntilSquare(12);
        $this->assertEquals(3, $o->getManhattanDistance());
        $this->assertEquals(2, $o->getX());
        $this->assertEquals(1, $o->getY());
    }
    public function testCase3()
    {
        $o = new SpiralMemory();
        $o->buildUntilSquare(23);
        $this->assertEquals(2, $o->getManhattanDistance());
        $this->assertEquals(0, $o->getX());
        $this->assertEquals(-2, $o->getY());
    }
    public function testCase4()
    {
        $o = new SpiralMemory();
        $o->buildUntilSquare(1024);
        $this->assertEquals(31, $o->getManhattanDistance());
    }
    public function testFinal()
    {
        $o = new SpiralMemory();
        $o->buildUntilSquare(325489);
        $this->assertEquals(552, $o->getManhattanDistance());
        $this->assertEquals(-267, $o->getX());
        $this->assertEquals(-285, $o->getY());
    }
    public function testPartTwoCase1()
    {
        $o = new SpiralMemory();
        $o->buildUntilSquare(1);
        $this->assertEquals(1, $o->getLastValue());
    }
    public function testPartTwoCase2()
    {
        $o = new SpiralMemory();
        $o->buildUntilSquare(2);
        $this->assertEquals(1, $o->getLastValue());
    }
    public function testPartTwoCase3()
    {
        $o = new SpiralMemory();
        $o->buildUntilSquare(3);
        $this->assertEquals(2, $o->getLastValue());
    }
    public function testPartTwoCase4()
    {
        $o = new SpiralMemory();
        $o->buildUntilSquare(4);
        $this->assertEquals(4, $o->getLastValue());
    }
    public function testPartTwoCase5()
    {
        $o = new SpiralMemory();
        $o->buildUntilSquare(5);
        $this->assertEquals(5, $o->getLastValue());
    }
    public function testPartTwoCase6()
    {
        $o = new SpiralMemory();
        $o->buildUntilValueLargerThan(5);
        $this->assertEquals(10, $o->getLastValue());
    }
    public function testPartTwoCase7()
    {
        $o = new SpiralMemory();
        $o->buildUntilValueLargerThan(26);
        $this->assertEquals(54, $o->getLastValue());
    }
    public function testPartTwoFinal()
    {
        $o = new SpiralMemory();
        $o->buildUntilValueLargerThan(325489);
        $this->assertEquals(330785, $o->getLastValue());
    }
}
