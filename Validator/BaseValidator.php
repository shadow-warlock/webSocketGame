<?php


namespace WebSocketGame\Validator;


use WebSocketGame\Model\User;

class BaseValidator {
    public static function validateUser(User $user) {
        return $user === null || $user->getHp() === 0;
    }
}
