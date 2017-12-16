<?php

class InverseCaptchaHalfway {
    private static function getComparedIndexTo($i, $len) {
        $stepsAhead = $len / 2;
        $j = $i + $stepsAhead;
        return $j % $len; // circular
    }

    static function calc($line) {
        $total = 0;
        for ($i=0, $len=strlen($line); $i<$len; $i++) {
            $j = self::getComparedIndexTo($i, $len);
            if ($line[$i] == $line[$j]) $total += intval($line[$i]);
        }
        return $total;
    }
}
