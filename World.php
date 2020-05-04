<?php

namespace WebSocketGame;

use JsonSerializable;

class World implements JsonSerializable{
    private $width;
    private $height;
    private $users = [];
    private $damagedObject = [];
    private $droppedObject = [];

     public function __construct(){
         $this->width = 10000;
         $this->height = 10000;
         for ($i = 0; $i < 5; $i++) {
             $this->addDamagedObject("stone", 50, 200);
         };
     }

    public function jsonSerialize() {
        return [
            "width" => $this->width,
            "height" => $this->height,
            "users" => $this->users,
            "droppedObject" => $this->droppedObject,
            "damagedObject" => $this->damagedObject];
    }

    public function addUser($connection, $login){
        $this->users[]=new User($connection, $login, rand(0,$this->width), rand(0,$this->height));
    }

    public function removeUser($user){
        unset($this->users[$user]);
        $this->users = array_values($this->users);
    }

    public function addDamagedObject($name, $radius, $hp){
        $this->damagedObject[]=new TakingDamageObject($name, rand(0,$this->width), rand(0,$this->height), $radius, $hp);
    }

    public function addDroppedObject($name, $radius, $hp){
        $this->damagedObject[]=new TakingDamageObject($name, rand(0,$this->width), rand(0,$this->height), $radius, $hp);
    }

    public function findUserByConnection($connection)
    {
        foreach ($this->users as $user) {
            if ($user->getConnection() === $connection) {
                return $user;
            }
        }
        return null;
    }

    public function mergeObject(){
        return array_merge($this->users, $this->damagedObject, $this->droppedObject);
    }

    public function getWidth(): int
    {
        return $this->width;
    }
    public function getHeight(): int
    {
        return $this->height;
    }
    public function getUsers(): array
    {
        return $this->users;
    }
    public function getDamagedObject(): array
    {
        return $this->damagedObject;
    }
}
