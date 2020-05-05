<?php


namespace WebSocketGame\Validator;


use WebSocketGame\Model\User;
use WebSocketGame\Utilities;
use WebSocketGame\World;

class MoveValidator {
    public static function validateUserMove(World $world, User $user, int $x, int $y) {
        $coords = $user->getCoordinates();
        return !(
            ($coords["x"] + $x > $world->getWidth()) ||
            ($coords["x"] + $x < 0 ) ||
            ($coords["y"] + $y > $world->getHeight()) ||
            ($coords["y"] + $y < 0)||
            (self::checkCrossing($world, $coords, $x, $y, $user->getRadius()))
        );
    }

    private static function checkCrossing(World $world, $coords, $x, $y, $radius): bool{
        $coords["x"] = $coords["x"]+$x;
        $coords["y"] = $coords["y"]+$y;
        foreach ($world->getDamagedObjects() as $object) {
            $squaredDinstance = Utilities::findSquaredDinstance($coords["x"], $coords["y"], $object->getCoordinates()["x"], $object->getCoordinates()["y"]);
            if (pow(($object->getRadius() + $radius),2) > ($squaredDinstance)){
                return true;
            }
        }
        return false;
    }
}
