<?php

class IHeardYouLikeRegisters
{
    private $_instructions = array();
    private $_registers = array();
    private $_pos = 0;
    private $_highestValue = 0;

    function setInstructions($lines) {
        $this->_instructions = explode("\n", $lines);
    }
    function step() {
        $instruction = $this->_instructions[$this->_pos++];
        list($reg_to_change, $op, $change_val, $if, $reg_cond, $cond, $cond_val) =
            explode(' ', $instruction);

        $fnCondition = 'is' . str_replace(
            array('<', '=', '>', '!'), array('L', 'E', 'G', 'N'), $cond
        );
        if (!isset($this->_registers[$reg_cond]))
            $this->_registers[$reg_cond] = 0;
        if (!isset($this->_registers[$reg_to_change]))
            $this->_registers[$reg_to_change] = 0;
        if ($this->{$fnCondition}($reg_cond, $cond_val)) {
            $fnOperation = 'do' . ucfirst($op);
            $this->{$fnOperation}($reg_to_change, $change_val);
        }

        if ($this->_highestValue < $this->_registers[$reg_to_change]) {
            $this->_highestValue = $this->_registers[$reg_to_change];
        }

        return array($reg_to_change, $this->_registers[$reg_to_change]);
    }
    function reset() {
        $this->_pos = 0;
        $this->_registers = array();
    }
    function run() {
        while($this->_pos < sizeOf($this->_instructions))
            $this->step();
    }
    function getLargestValue() {
        return max($this->_registers);
    }
    function getLargestValueEver() {
        return $this->_highestValue;
    }

    private function isL ($id, $value) { return $this->_registers[$id] <  $value; }
    private function isG ($id, $value) { return $this->_registers[$id] >  $value; }
    private function isLE($id, $value) { return $this->_registers[$id] <= $value; }
    private function isGE($id, $value) { return $this->_registers[$id] >= $value; }
    private function isEE($id, $value) { return $this->_registers[$id] == $value; }
    private function isNE($id, $value) { return $this->_registers[$id] != $value; }

    private function doInc($id, $value) { $this->_registers[$id] += $value; }
    private function doDec($id, $value) { $this->_registers[$id] -= $value; }
}
