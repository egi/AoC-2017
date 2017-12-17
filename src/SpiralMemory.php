<?php

class SpiralMemory {

    private $x = 0;
    private $y = 0;
    private $rect_x_min = 0;
    private $rect_x_max = 0;
    private $rect_y_min = 0;
    private $rect_y_max = 0;

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
            // where to put the number
            $this->putAndPlanDirection($dir);
            //error_log("$i (".$this->x.", ".$this->y."), going $dir\n", 3, '/tmp/log.txt');

            // calculate next number
            $i++;
        }
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
    }
}
