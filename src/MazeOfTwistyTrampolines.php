<?php

class MazeOfTwistyTrampolines
{
    private $instructions = array();

    function setInstructions($lines) {
        $this->instructions = explode("\n", $lines);
        array_map('intval', $this->instructions);
    }

    function getInstructions() {
        return implode(' ', $this->instructions);
    }

    function run() {
        $i = 0;
        $pos = 0;
        $max = sizeOf($this->instructions);
        while($pos < $max) {
            $pos += $this->instructions[$pos]++;
            ++$i;
        }
        return $i;
    }

    function runStranger() {
        $i = 0;
        $pos = 0;
        $max = sizeOf($this->instructions);
        while($pos < $max) {
            $to_offset = $this->instructions[$pos];
            if ($to_offset >= 3)
                $this->instructions[$pos]--;
            else
                $this->instructions[$pos]++;

            $pos += $to_offset;
            ++$i;
        }
        return $i;
    }
}
