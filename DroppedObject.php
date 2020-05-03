<?php


namespace WebSocketGame;

class DroppedObject extends GameObject{
    private $quantity;

    public function __construct($name, $radius, $quantity, $x, $y){
        parent::__construct($name, $radius, $x, $y);
        $this->quantity=$quantity;
    }

    public function jsonSerialize() {
        return array_merge(parent::jsonSerialize(),[
            "quantity" => $this->quantity,]);
    }

    public function setQuantity($quantity): void
    {
        $this->quantity = $quantity;
    }


}