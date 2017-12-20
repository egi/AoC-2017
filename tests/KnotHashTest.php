<?php

use PHPUnit\Framework\TestCase;

require_once('src/KnotHash.php');

class KnotHashTest extends TestCase {
    public function testStep()
    {
        $o = new KnotHash('3,4,1,5');
        $o->setList(range(0, 4));

        $this->assertEquals(0, $o->getPosition());
        $this->assertEquals(0, $o->getElement());
        $this->assertEquals(0, $o->getSkipSize());

        $this->assertEquals(3, $o->getLength());
        $this->assertEquals(array(2, 1, 0, 3, 4), $o->step()->getList());

        $this->assertEquals(3, $o->getPosition());
        $this->assertEquals(3, $o->getElement());
        $this->assertEquals(1, $o->getSkipSize());

        $this->assertEquals(4, $o->getLength());
        $this->assertEquals(array(3, 4, 2, 1), $o->sliceList());
        $this->assertEquals(array(4, 3, 0, 1, 2), $o->step()->getList());

        $this->assertEquals(3, $o->getPosition());
        $this->assertEquals(1, $o->getElement());
        $this->assertEquals(2, $o->getSkipSize());

        $this->assertEquals(1, $o->getLength());
        $this->assertEquals(array(4, 3, 0, 1, 2), $o->step()->getList());

        $this->assertEquals(1, $o->getPosition());
        $this->assertEquals(3, $o->getElement());
        $this->assertEquals(3, $o->getSkipSize());

        $this->assertEquals(5, $o->getLength());
        $this->assertEquals(array(3, 4, 2, 1, 0), $o->step()->getList());

        $this->assertEquals(4, $o->getPosition());
        $this->assertEquals(0, $o->getElement());
        $this->assertEquals(4, $o->getSkipSize());

        $final = $o->getList();
        $this->assertEquals(12, $final[0] * $final[1]);
    }
    public function testRun()
    {
        $o = new KnotHash('3,4,1,5');
        $o->setList(range(0, 4));
        $final = $o->run()->getList();
        $this->assertEquals(12, $final[0] * $final[1]);
    }
    public function testFinal()
    {
        $o = new KnotHash('97,167,54,178,2,11,209,174,119,248,254,0,255,1,64,190');
        $o->setList(range(0, 255));
        $final = $o->run()->getList();
        $this->assertEquals(8536, $final[0] * $final[1]);
    }
}
