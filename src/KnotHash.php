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
    function __construct($str) {
        $this->_lengthSequence = explode(',', $str);
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
    function getList() {
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
    function run() {
        while($this->_length < sizeOf($this->_lengthSequence)) {
            $this->step();
        }
        return $this;
    }
}
