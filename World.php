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

    public function addUser($user){
        $this->users[]=$user;
    }
    public function addStone($stone){
        $this->stones[]=$stone;
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