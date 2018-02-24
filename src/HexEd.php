<?php

/**
 * @see https://www.redblobgames.com/grids/hexagons/
 * @see http://adventofcode.com/2017/day/11
 **/
class HexEd
{
    private $_x = 0;
    private $_y = 0;
    private $_z = 0;
    private $_furthestSteps = 0;

    function resetAndMove($steps) {
        $this->_x = 0;
        $this->_y = 0;
        $this->_z = 0;
        foreach (explode(',', $steps) as $step) {
            switch($step) {
            case 'nw': $this->_x -= 1; $this->_y += 1; $this->_z += 0; break;
            case 'se': $this->_x += 1; $this->_y -= 1; $this->_z += 0; break;
            case 'n':  $this->_x -= 0; $this->_y += 1; $this->_z -= 1; break;
            case 's':  $this->_x += 0; $this->_y -= 1; $this->_z += 1; break;
            case 'ne': $this->_x += 1; $this->_y += 0; $this->_z -= 1; break;
            case 'sw': $this->_x -= 1; $this->_y -= 0; $this->_z += 1; break;
            }
            $this->_furthestSteps = max($this->_furthestSteps, $this->getDistance());
        }
        return $this;
    }
    function getDistance() {
        return max(abs($this->_x), abs($this->_y), abs($this->_z));
    }
    function getFurthestDistance() {
        return $this->_furthestSteps;
    }
}
