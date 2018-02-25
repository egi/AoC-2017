<?php

/**
 * @see http://adventofcode.com/2017/day/12
 **/
class DigitalPlumber
{
    private $plumbingMap = array();
    private $connected = array();

    public function __construct($records) {
        $rows = explode("\n", $records);
        foreach ($rows as $row) {
            $row = trim($row);
            if (empty($row)) continue;
            list($k, $v) = explode(' <-> ', $row);
            $this->plumbingMap[$k] = explode(', ', $v);
        }
    }
    public function connectedTo($id) {
        $this->connected[$id] = true;
        foreach($this->plumbingMap[$id] as $program) {
            if (!isset($this->connected[$program]))
                $this->connectedTo($program);
        }
        return sizeOf($this->connected);
    }
}
