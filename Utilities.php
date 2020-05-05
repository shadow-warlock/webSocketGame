<?php

namespace WebSocketGame;

class Utilities{
    static function radiusCheck($x, $x0, $y, $y0, $r): bool{
        return ((pow(($x - $x0), 2) + pow(($y - $y0), 2)) <= pow($r, 2));
    }

    static function generatedDroppedCoordinates($x,$y,$radius){
        return [
            "x" => rand($x - $radius, $x + $radius),
            "y" => rand($y - $radius, $y + $radius),
        ];
    }

    static function findSquaredDinstance($x1, $y1, $x2, $y2){
        return ((pow(($x2-$x1), 2) + pow(($y2 - $y1), 2)));
    }
}
