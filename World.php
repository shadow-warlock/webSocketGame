<?php

namespace WebSocketGame;

use JsonSerializable;

class World implements JsonSerializable{
    private $width;
    private $height;
    private $users = [];
    private $stones = [];

    public function __construct(){
        $this->width=10000;
        $this->height=10000;
    }

    public function jsonSerialize() {
        return [
            "width" => $this->width,
            "height" => $this->height,
            "users" => $this->users,
            "stones" => $this->stones];
    }

    public function addUser($connection, $login){
        $this->users[]=new User($connection, $login, rand(0,$this->width), rand(0,$this->height));
    }

    public function removeUser($user){
        unset($this->users[$user]);
        $this->users = array_values($this->users);
    }

    public function addStone(){
        $this->stones[]=new GameObject(40,200, 200,100,200, rand(0,$this->width), rand(0,$this->height));
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
    public function getStones(): array
    {
        return $this->stones;
    }
}
