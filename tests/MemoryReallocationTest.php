<?php

use PHPUnit\Framework\TestCase;

require_once('src/MemoryReallocation.php');

class MemoryReallocationTest extends TestCase {
    function testCase1() {
        $o = new MemoryReallocation(array(0, 2, 7, 0));
        $this->assertEquals(3, $o->getBankToDistribute());
        $this->assertEquals(7, $o->getNumToDistribute());
        $this->assertEquals('2 4 1 2', $o->step()->toString());
        $this->assertFalse($o->isCycleSeen());

        $this->assertEquals(2, $o->getBankToDistribute());
        $this->assertEquals(4, $o->getNumToDistribute());
        $this->assertEquals('3 1 2 3', $o->step()->toString());
        $this->assertFalse($o->isCycleSeen());

        $this->assertEquals(1, $o->getBankToDistribute());
        $this->assertEquals(3, $o->getNumToDistribute());
        $this->assertEquals('0 2 3 4', $o->step()->toString());
        $this->assertFalse($o->isCycleSeen());

        $this->assertEquals(4, $o->getBankToDistribute());
        $this->assertEquals(4, $o->getNumToDistribute());
        $this->assertEquals('1 3 4 1', $o->step()->toString());
        $this->assertFalse($o->isCycleSeen());

        $this->assertEquals(3, $o->getBankToDistribute());
        $this->assertEquals('2 4 1 2', $o->step()->toString());
        $this->assertTrue($o->isCycleSeen());

        $this->assertEquals(5, $o->getCycleDone());
        $this->assertEquals(1, $o->getCycleSeen());
        $this->assertEquals(4, $o->getLoopSize());
    }
    function testCase() {
        $o = new MemoryReallocation(array(0, 2, 7, 0));
        try {
            $o->reallocate();
        } catch (InfiniteLoopException $e) {
            $this->assertEquals(5, $e->getCycleDone());
        }
    }
    function testFinal() {
        $o = new MemoryReallocation(explode("\t", "2	8	8	5	4	2	3	1	5	5	1	2	15	13	5	14"));
        try {
            $o->reallocate();
        } catch (InfiniteLoopException $e) {
            $this->assertEquals(3156, $e->getCycleDone());
            $this->assertEquals(1610, $e->getLoopSize());
        }
    }
}
