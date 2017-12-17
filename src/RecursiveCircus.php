<?php

class UnbalancedException extends Exception
{
    private $_wrongWeightedName = '';
    private $_wrongWeightedWeight = 0;
    private $_rightWeightedWeight = 0;

    function getWrongWeightedName()   { return $this->_wrongWeightedName; }
    function getWrongWeightedWeight() { return $this->_wrongWeightedWeight; }
    function getRightWeightedWeight() { return $this->_rightWeightedWeight; }

    function setWrongWeightedName($n)   { $this->_wrongWeightedName   = $n; }
    function setWrongWeightedWeight($i) { $this->_wrongWeightedWeight = $i; }
    function setRightWeightedWeight($i) { $this->_rightWeightedWeight = $i; }
}

class RecursiveCircus
{
    private $_parentMap = array();
    private $_childrenMap = array();
    private $_weightMap = array();

    function setList($list) {
        foreach(explode("\n", $list) as $row) {
            list($parent, $weight, $hasChild, $children) = explode(' ', "$row  ", 4);

            $this->_weightMap[$parent] = intval(trim($weight, '()'));
            if ('->' == $hasChild) {
                $this->_childrenMap[$parent] = explode(', ', trim($children));
                foreach($this->_childrenMap[$parent] as $child) {
                    $this->_parentMap[$child] = $parent;
                }
            }
            if (!isset($this->_parentMap[$parent])) {
                $this->_parentMap[$parent] = null;
            }
        }
    }

    function getSelfWeight($name) {
        return $this->_weightMap[$name];
    }

    function getWeight($parent) {
        $total = $this->_weightMap[$parent];

        if (isset($this->_childrenMap[$parent])) {
            foreach($this->_childrenMap[$parent] as $c) {
                $childrenWeightMap[$c] = $this->getWeight($c);
            }
            $res = array_count_values($childrenWeightMap);
            if (sizeOf($res) > 1) {
                $e = new UnbalancedException();
                $e->setWrongWeightedWeight(array_search(1, $res));
                $e->setWrongWeightedName(array_search($e->getWrongWeightedWeight(), $childrenWeightMap));
                unset($childrenWeightMap[$e->getWrongWeightedName()]);
                $e->setRightWeightedWeight(reset($childrenWeightMap));
                throw $e;
            }

            // all discs are in balance
            $total += reset($res) * key($res);
        }
        return $total;
    }

    function validateChildWeight($parent) {
        foreach($this->_childrenMap[$parent] as $c) {
            $childrenWeightMap[$c] = $this->getWeight($c);
        }
        return sizeOf(array_count_values($childrenWeightMap)) == 1;
    }

    function getBottomProgram() {
        return array_search(null, $this->_parentMap);
    }
}
