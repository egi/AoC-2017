<?php

use PHPUnit\Framework\TestCase;

require_once('src/KnotHash.php');

class KnotHashTest extends TestCase {
    public function testStep()
    {
        $o = new KnotHash('3,4,1,5', $asBytes=false);
        $o->setList(range(0, 4));

        $this->assertEquals(0, $o->getPosition());
        $this->assertEquals(0, $o->getElement());
        $this->assertEquals(0, $o->getSkipSize());

        $this->assertEquals(3, $o->getLength());
        $this->assertEquals(array(2, 1, 0, 3, 4), $o->step()->getSparseHash());

        $this->assertEquals(3, $o->getPosition());
        $this->assertEquals(3, $o->getElement());
        $this->assertEquals(1, $o->getSkipSize());

        $this->assertEquals(4, $o->getLength());
        $this->assertEquals(array(3, 4, 2, 1), $o->sliceList());
        $this->assertEquals(array(4, 3, 0, 1, 2), $o->step()->getSparseHash());

        $this->assertEquals(3, $o->getPosition());
        $this->assertEquals(1, $o->getElement());
        $this->assertEquals(2, $o->getSkipSize());

        $this->assertEquals(1, $o->getLength());
        $this->assertEquals(array(4, 3, 0, 1, 2), $o->step()->getSparseHash());

        $this->assertEquals(1, $o->getPosition());
        $this->assertEquals(3, $o->getElement());
        $this->assertEquals(3, $o->getSkipSize());

        $this->assertEquals(5, $o->getLength());
        $this->assertEquals(array(3, 4, 2, 1, 0), $o->step()->getSparseHash());

        $this->assertEquals(4, $o->getPosition());
        $this->assertEquals(0, $o->getElement());
        $this->assertEquals(4, $o->getSkipSize());

        $final = $o->getSparseHash();
        $this->assertEquals(12, $final[0] * $final[1]);
    }
    public function testRun()
    {
        $o = new KnotHash('3,4,1,5', $asBytes=false);
        $o->setList(range(0, 4));
        $final = $o->runOneRound()->getSparseHash();
        $this->assertEquals(12, $final[0] * $final[1]);
    }
    public function testFinal()
    {
        $o = new KnotHash('97,167,54,178,2,11,209,174,119,248,254,0,255,1,64,190', $asBytes=false);
        $o->setList(range(0, 255));
        $final = $o->runOneRound()->getSparseHash();
        $this->assertEquals(8536, $final[0] * $final[1]);
    }
    public function testInputAsStringOfBytes()
    {
        $o = new KnotHash('1,2,3');
        $this->assertEquals(array(49,44,50,44,51,17,31,73,47,23), $o->getLengthSequence());
    }
    public function testDensing()
    {
        $this->assertEquals(64, KnotHash::dense(array(65,27,9,1,4,3,40,50,91,7,6,0,2,5,68,22)));
    }
    public function testPartTwo()
    {
        $o = new KnotHash('');
        $o->setList(range(0, 255));
        $this->assertEquals('a2582a3a0e66e6e86e3812dcb672a272', $o->runFullRound()->getDenseHash());
        $o = new KnotHash('AoC 2017');
        $o->setList(range(0, 255));
        $this->assertEquals('33efeb34ea91902bb2f59c9920caa6cd', $o->runFullRound()->getDenseHash());
        $o = new KnotHash('1,2,3');
        $o->setList(range(0, 255));
        $this->assertEquals('3efbe78a8d82f29979031a4aa0b16a9d', $o->runFullRound()->getDenseHash());
        $o = new KnotHash('1,2,4');
        $o->setList(range(0, 255));
        $this->assertEquals('63960835bcdc130f0b66d7ff4f6a5a8e', $o->runFullRound()->getDenseHash());
    }
    public function testFinal2()
    {
        $o = new KnotHash('97,167,54,178,2,11,209,174,119,248,254,0,255,1,64,190');
        $this->assertEquals('aff593797989d665349efe11bb4fd99b', $o->hash());
    }
}
