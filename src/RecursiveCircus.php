<?php

class RecursiveCircus
{
    private $_parentMap = array();
    function setList($list) {
        foreach(explode("\n", $list) as $row) {
            list($name, $weight, $hasDisc, $discs) = explode(' ', "$row  ", 4);
            if ('->' == $hasDisc) {
                foreach(explode(', ', $discs) as $d) {
                    $this->_parentMap[trim($d)] = $name;
                }
            }
            if (!isset($this->_parentMap[$name])) {
                $this->_parentMap[$name] = null;
            }
        }
    }
    function getBottomProgram() {
        return array_search(null, $this->_parentMap);
    }
}
