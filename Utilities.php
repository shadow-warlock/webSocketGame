<?php

namespace WebSocketGame;

class Utilities{
    static function radiusCheck($x, $y, $x0, $y0, $r): bool{
        return ((pow(($x - $x0), 2) + pow(($y - $y0), 2)) <= pow($r, 2));
    }
}