<?php


namespace WebSocketGame\Validator;


use WebSocketGame\Model\User;
use WebSocketGame\World;

class MoveValidator {
    public static function validateUserMove(World $world, User $user, int $x, int $y){
        $coords = $user->getCoordinates();
        return !($coords["x"] + $x < 0 || $coords["x"] + $x > $world->getWidth()
            || $coords["y"] + $y < 0 || $coords["y"] + $y > $world->getHeight());
    }
}
