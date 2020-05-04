<?php

namespace WebSocketGame;

use JsonSerializable;
use WebSocketGame\Factory\ObjectFactory;
use WebSocketGame\Model\TakingDamageObject;
use WebSocketGame\Model\User;
use WebSocketGame\Validator\MoveValidator;

class World implements JsonSerializable{
    private $width;
    private $height;
    private $users = [];
    private $damagedObjects = [];
    private $droppedObjects = [];

     public function __construct(){
         $this->width = 10000;
         $this->height = 10000;
         for ($i = 0; $i < 100; $i++) {
             $this->addDamagedObject("Stone");
         };
     }

    public function jsonSerialize() {
        return [
            "width" => $this->width,
            "height" => $this->height,
            "users" => $this->users,
            "droppedObjects" => $this->droppedObjects,
            "damagedObjects" => $this->damagedObjects];
    }

    public function moveUser(User $user, $horizontal, $vertical){
        if(MoveValidator::validateUserMove($this, $user, $horizontal, $vertical)){
            $user->move($horizontal, $vertical);
        }
    }

    public function melee(User $attacking, $x, $y){
        if ($attacking->meleeRadiusCheck($x, $y)) {
            foreach ($this->users as $attacked) {
                if ($attacking !== $attacked && $attacked->radiusCheck($x, $y)) {
                    if ($attacking->dealingDamage($attacked) == TakingDamageObject::DEAD){

                    }
                    return;
                }
            }
            foreach ($this->damagedObjects as $attacked) {
                if ($attacking !== $attacked && $attacked->radiusCheck($x, $y)) {
                    if ($attacking->dealingDamage($attacked) == TakingDamageObject::DEAD){
                        foreach ($attacked->droppingLoot() as $droppedItem){
                            $this->addDroppedObject($droppedItem["item"], $droppedItem["x"], $droppedItem["y"], $droppedItem["quantity"]);
                        }
                        $this->removeDamagedObject($attacked);
                    }
                    return;
                }
            }
            foreach ($this->droppedObjects as $attacked) {
                if ($attacking !== $attacked && $attacked->radiusCheck($x, $y)) {
                    $this->takeObject($attacking,$attacked);
                    return;
                }
            }
        }
    }

    public function takeObject($taking,$taked){

    }

    public function addUser($connection, $login){
        $this->users[]=new User($connection, $login, rand(0,$this->width), rand(0,$this->height));
    }

    public function removeUser($user){
        unset($this->users[$user]);
        $this->users = array_values($this->users);
    }

    public function addDamagedObject($name){
         $factory = new ObjectFactory();
         $object = $factory->create($name, rand(0,$this->width), rand(0,$this->height));
         if($object !== null){
             $this->damagedObjects[] = $object;
         }
    }

    public function removeDamagedObject($damagedObject){
        unset($this->damagedObjects[array_search($damagedObject, $this->damagedObjects)]);
        $this->damagedObjects = array_values($this->damagedObjects);
    }

    public function addDroppedObject($name, $x, $y, $quantity){

    }

    public function removeDroppedObject($droppedObject){
        unset($this->droppedObjects[array_search($droppedObject, $this->droppedObjects)]);
        $this->droppedObjects = array_values($this->droppedObjects);
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
    public function getDamagedObjects(): array
    {
        return $this->damagedObjects;
    }
}
