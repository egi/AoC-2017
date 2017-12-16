<?php

class CorruptionChecksum {
    private $checksum = 0;
    private $strategy = 'largestDifference';

    private function largestDifference($columns) {
        return end($columns) - reset($columns);
    }

    private function evenlyDivisible($columns) {
        for($i=sizeOf($columns)-1; $i>=0; $i--) {
            for($j=0; $j<$i; $j++) {
                if ($columns[$i] % $columns[$j] == 0) {
                    return $columns[$i] / $columns[$j];
                }
            }
        }
    }

    function addRow($row) {
        $columns = explode("\t", $row);
        sort($columns, SORT_NUMERIC);
        $this->checksum += $this->{$this->strategy}($columns);
    }

    function setStrategy($strategy) {
        $this->strategy = $strategy;
    }

    function getChecksum() {
        return $this->checksum;
    }
}
