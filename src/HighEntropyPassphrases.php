<?php

class HighEntropyPassphrases {
    static function validate($passphrase) {
        $words = explode(' ', $passphrase);
        return sizeOf($words) == sizeOf(array_unique($words));
    }
    static function validateNoAnagrams($passphrase) {
        $words = explode(' ', $passphrase);
        foreach ($words as $k=>$w) {
            $letters = str_split($w);
            sort($letters);
            $words[$k] = implode('', $letters);
        }
        return sizeOf($words) == sizeOf(array_unique($words));
    }
}
