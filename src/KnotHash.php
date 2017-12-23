<?php

class KnotHash
{
    private $_list = array();
    private $_nlist = 0;
    private $_position = 0;
    private $_skipSize = 0;

    private $_lengthSequence = array();
    private $_length = 0;

    function setList($list) {
        $this->_list = $list;
        $this->_nlist = sizeOf($list);
    }
    function __construct($str, $asBytes=true) {
        if ($asBytes) {
            $this->_lengthSequence = array();
            for($i=0; $i<strlen($str); $i++) {
                $this->_lengthSequence[] = ord($str[$i]);
            }
            $this->_lengthSequence = array_merge($this->_lengthSequence, array(17,31,73,47,23));
        } else {
            $this->_lengthSequence = array_map('intval', explode(',', $str));
        }
    }
    function getPosition() {
        return $this->_position;
    }
    function getElement() {
        return $this->_list[ $this->_position ];
    }
    function getSkipSize() {
        return $this->_skipSize;
    }
    function getLength() {
        return $this->_lengthSequence[ $this->_length ];
    }
    function getLengthSequence() {
        return $this->_lengthSequence;
    }
    function getSparseHash() {
        return $this->_list;
    }
    function sliceList() {
        $result = array();
        for($i=0; $i<$this->getLength(); $i++) {
            $result[] = $this->_list[ ($i + $this->_position) % $this->_nlist ];
        }
        return $result;
    }
    private function updateList($sublist_reversed) {
        foreach($sublist_reversed as $k=>$v) {
            $this->_list[ ($k + $this->_position) % $this->_nlist ] = $v;
        }
    }
    function step() {
        $sublist = $this->sliceList();
        $sublist_reversed = array_reverse($sublist);
        $this->updateList($sublist_reversed);
        $this->_position = ($this->_position + $this->getLength() + $this->_skipSize) % $this->_nlist;
        $this->_skipSize++;
        $this->_length++;
        return $this;
    }
    function runOneRound() {
        $this->_length = 0;
        while($this->_length < sizeOf($this->_lengthSequence)) {
            $this->step();
        }
        return $this;
    }
    function runFullRound() {
        for($i=0; $i<64; $i++) {
            $this->runOneRound();
        }
        return $this;
    }
    function getDenseHash() {
        $denseHash = '';
        for($i=0; $i<$this->_nlist; $i+=16) {
            $denseHash .= sprintf('%02x', (self::dense(array_slice($this->_list, $i, 16))));
        }
        return $denseHash;
    }
    function hash() {
        $this->setList(range(0, 255));
        return $this->runFullRound()->getDenseHash();
    }
    static function dense($a) {
        return $a[0] ^ $a[1] ^ $a[ 2] ^ $a[ 3] ^ $a[ 4] ^ $a[ 5] ^ $a[ 6] ^ $a[ 7] ^ 
               $a[8] ^ $a[9] ^ $a[10] ^ $a[11] ^ $a[12] ^ $a[13] ^ $a[14] ^ $a[15];
    }
}
