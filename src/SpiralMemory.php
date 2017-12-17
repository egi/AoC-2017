<?php

class SpiralMemory {

    private $x = 0;
    private $y = 0;
    private $rect_x_min = 0;
    private $rect_x_max = 0;
    private $rect_y_min = 0;
    private $rect_y_max = 0;
    private $cell = array();

    private function getCell($x, $y)
    {
        if (isset( $this->cell[$x]) && isset($this->cell[$x][$y]))
            return $this->cell[$x][$y];
        return 0;
    }
    private function sumAdjacent($x, $y) {
        return
            $this->getCell($x-1, $y+1) +
            $this->getCell($x  , $y+1) +
            $this->getCell($x+1, $y+1) +
            $this->getCell($x-1, $y  ) +
            $this->getCell($x+1, $y  ) +
            $this->getCell($x-1, $y-1) +
            $this->getCell($x  , $y-1) +
            $this->getCell($x+1, $y-1);
    }
    private function putAndPlanDirection(&$dir) {
        switch($dir) {

        case 'right':
            $this->x += 1;
            if ($this->rect_x_max < $this->x) {
                $this->rect_x_max = $this->x;
                $dir = 'up';
            }
            break;

        case 'up':
            $this->y += 1;
            if ($this->rect_y_max < $this->y) {
                $this->rect_y_max = $this->y;
                $dir = 'left';
            }
            break;

        case 'left':
            $this->x -= 1;
            if ($this->rect_x_min > $this->x) {
                $this->rect_x_min = $this->x;
                $dir = 'down';
            }
            break;

        case 'down':
            $this->y -= 1;
            if ($this->rect_y_min > $this->y) {
                $this->rect_y_min = $this->y;
                $dir = 'right';
            }
            break;

        default:
            $dir = 'right';
        }

    }
    function buildUntilSquare(int $max) {
        $i = 1;
        $dir = 'none';
        while ($i <= $max) {
            $this->putAndPlanDirection($dir);
            //error_log("$i (".$this->x.", ".$this->y."), going $dir\n", 3, '/tmp/log.txt');
            $this->cell[$this->x][$this->y] = ($this->x == 0 && $this->y == 0)
                ? 1
                : $this->sumAdjacent($this->x, $this->y);
            $i++;
        }
    }
    function buildUntilValueLargerThan(int $max) {
        $dir = 'none';
        do {
            $this->putAndPlanDirection($dir);
            $lastValue = $this->cell[$this->x][$this->y] = ($this->x == 0 && $this->y == 0)
                ? 1
                : $this->sumAdjacent($this->x, $this->y);
        } while ($lastValue <= $max);
    }
    function getX() {
        return $this->x;
    }
    function getY() {
        return $this->y;
    }
    function getManhattanDistance()
    {
        return abs($this->x) + abs($this->y);
    }
    function getLastValue()
    {
        return $this->getCell($this->x, $this->y);
    }
}
