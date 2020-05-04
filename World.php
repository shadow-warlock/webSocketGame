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
    private $objectFactory;

     public function __construct(){
         $this->objectFactory = new ObjectFactory();
         $this->width = 10000;
         $this->height = 10000;
         $json = file_get_contents(__DIR__ . "/config/StartConfig.json");
         $config = json_decode($json, true);
         foreach($config as $obj => $count){
             for($i = 0; $i < $count; $i++){
                 $this->damagedObjects[] = $this->objectFactory->create($obj, rand(0,$this->width), rand(0,$this->height));
             }
         }
     }

    public function jsonSerialize() {
        return [
            "width" => $this->width,
            "height" => $this->height,
            "users" => $this->users,
            "droppedObjects" => $this->droppedObjects,
            "damagedObjects" => $this->damagedObjects
        ];
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
         $object = $this->objectFactory->create($name, rand(0,$this->width), rand(0,$this->height));
         if($object !== null){
             $this->damagedObjects[] = $object;
         }
    }

    public function removeDamagedObject($damagedObject){
        unset($this->damagedObjects[array_search($damagedObject, $this->damagedObjects)]);
        $this->damagedObjects = array_values($this->damagedObjects);
    }

    public function addDroppedObject($name, $x, $y, $quantity){
        $object = $this->objectFactory->createDropped($name, $x, $y, $quantity);
        if($object !== null){
            $this->droppedObjects[] = $object;
        }
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
