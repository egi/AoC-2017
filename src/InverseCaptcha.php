<?php

class InverseCaptcha {
    static function calc($line) {
        $total = 0;
        for ($i=0, $len=strlen($line); $i<$len; $i++) {
            $j = ($i == $len-1) ? 0 : $i + 1; // circular
            if ($line[$i] == $line[$j]) $total += intval($line[$i]);
        }
        return $total;
    }
}
