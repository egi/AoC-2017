<?php

class StreamProcessing
{
    private $_lastGarbage = '';
    private $_count = 0;
    private $_score = 0;
    private $_depth = 0;
    private $_countTotalNonCanceledGarbage = 0;

    const STATE_NONE      = 0;
    const STATE_GARBAGE   = 1;
    const STATE_GROUP     = 2;
    const STATE_CANCELLED = 3;

    private $stateStack = array();

    private function pullState() {
        array_pop($this->stateStack);
        return end($this->stateStack);
    }

    private function pushState($state) {
        array_push($this->stateStack, $state);
        return $state;
    }

    function setStream($stream) {

        $this->_lastGarbage = '';
        $this->_count = 0;
        $this->_score = 0;
        $this->_depth = 0;
        $this->stateStack = array();
        $this->_countTotalNonCanceledGarbage = 0;

        $state = $this->pullState();
        for ($i=0; $i<strlen($stream); $i++) {

            $char = $stream[$i];

            switch($state) {

            case self::STATE_CANCELLED:
                $this->_lastGarbage .= $char;
                $state = $this->pullState();
                break;

            case self::STATE_GARBAGE:
                switch($char) {
                case '!':
                    // In a futile attempt to clean up the garbage, some
                    // program has canceled some of the characters within it
                    // using !: inside garbage, any character that comes after
                    // ! should be ignored, including <, >, and even another !.
                    $state = $this->pushState(self::STATE_CANCELLED);
                    $this->_lastGarbage .= $char;
                    break;
                case '>':
                    $state = $this->pullState();
                    break;
                default:
                    $this->_lastGarbage .= $char;
                    $this->_countTotalNonCanceledGarbage++;
                    break;
                }
                break;

            case self::STATE_GROUP:
                switch($char) {
                case '{':
                    $state = $this->pushState(self::STATE_GROUP);
                    $this->_depth++;
                    break;
                case '}':
                    $state = $this->pullState();
                    $this->_count++;
                    $this->_score += $this->_depth;
                    $this->_depth--;
                    break;
                case '<':
                    // Sometimes, instead of a group, you will find garbage.
                    $state = $this->pushState(self::STATE_GARBAGE);
                    $this->_lastGarbage = '';
                    break;
                }
                break;

            case self::STATE_NONE:
            default:
                switch($char) {
                case '{':
                    $state = $this->pushState(self::STATE_GROUP);
                    $this->_depth++;
                    break;
                case '<':
                    $state = $this->pushState(self::STATE_GARBAGE);
                    $this->_lastGarbage = '';
                    break;
                }
                break;
            }
        }
        return $this;
    }
    function getLastGarbage() {
        return $this->_lastGarbage;
    }
    function countGroups() {
        return $this->_count;
    }
    function scoreGroups() {
        return $this->_score;
    }
    function countTotalNonCanceledGarbage() {
        return $this->_countTotalNonCanceledGarbage;
    }
}
