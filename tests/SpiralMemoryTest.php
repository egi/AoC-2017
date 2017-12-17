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
        //$this->assertEquals(1, $o->getLastValue());
    }
}
