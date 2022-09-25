<?php

namespace PHPSystem;

class System {
    public static function isNull($value) {
        if (gettype($value) == "string") {
            return $value == null || strtolower($value) == 'null';
        } else {
            return $value == null;
        }
    }
}
