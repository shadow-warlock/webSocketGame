<?php


namespace WebSocketGame\Model;

class DroppedObject extends GameObject{
    private $quantity;

    public function __construct($name, $x, $y, $radius, $quantity){
        parent::__construct($name, $x, $y, $radius);
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
