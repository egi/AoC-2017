<?php

class InfiniteLoopException extends Exception {
    private $cycle = 0;
    private $loopSize = 0;
    function getCycleDone() { return $this->cycle; }
    function __construct($message=null, $i=0) { 
        $this->cycle = $i;
        parent::__construct($message);
    }
    function setLoopSize($i) {
        $this->loopSize = $i;
    }
    function getLoopSize() {
        return $this->loopSize;
    }
}

class MemoryReallocation
{
    private $banks = array();
    private $numBanks = 0;
    private $numToRedistribute = 0;
    private $posToRedistribute = 0;
    private $steps = array();

    function __construct($banks) {
        $this->banks = $banks;

        $this->numBanks = sizeOf($banks);
        $this->numToRedistribute = max($this->banks);
        $this->posToRedistribute = array_search($this->numToRedistribute, $this->banks);
    }
    function step() {
        $this->steps[] = $this->toString();

        $this->banks[ $this->posToRedistribute ] = 0;
        while ($this->numToRedistribute > 0) {
            $this->posToRedistribute = ($this->posToRedistribute+1) % $this->numBanks;
            $this->banks[ $this->posToRedistribute ]++;
            $this->numToRedistribute--;
        }

        $this->numToRedistribute = max($this->banks);
        $this->posToRedistribute = array_search($this->numToRedistribute, $this->banks);

        return $this;
    }
    // base-1 integer
    function getBankToDistribute() {
        return $this->posToRedistribute + 1;
    }
    function getNumToDistribute() {
        return $this->numToRedistribute;
    }
    function getCycleDone() {
        return sizeOf($this->steps);
    }
    function toString() {
        return implode(' ', $this->banks);
    }
    function isCycleSeen() {
        return (false !== array_search($this->toString(), $this->steps));
    }
    function getCycleSeen() {
        return array_search($this->toString(), $this->steps);
    }
    function getLoopSize() {
        return $this->getCycleDone() - $this->getCycleSeen();
    }
    function reallocate() {
        while(!$this->isCycleSeen()) {
            $this->step();
        }
        $e = new InfiniteLoopException(null, $this->getCycleDone());
        $e->setLoopSize( $this->getLoopSize() );
        throw $e;
    }
}
