<?php


namespace WebSocketGame\Validator;


use WebSocketGame\Model\User;
use WebSocketGame\World;

class MoveValidator {
    public static function validateUserMove(World $world, User $user, int $x, int $y) {
        $coords = $user->getCoordinates();
        return !(
            ($x > 0 && $coords["x"] + $x > $world->getWidth()) ||
            ($x < 0 && $coords["x"] + $x < 0) ||
            ($y > 0 && $coords["y"] + $y > $world->getHeight()) ||
            ($y < 0 && $coords["y"] + $y < 0)
        );
    }
}
