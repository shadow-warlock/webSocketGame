<?php


namespace WebSocketGame\Model;

class DroppedObject extends GameObject{
    private $quantity;
    private $maxQuantity;

    public function __construct($name, $x, $y, $radius, $maxQuantity, $quantity){
        parent::__construct($name, $x, $y, $radius);
        $this->quantity=$quantity;
        $this->maxQuantity=$maxQuantity;
    }

    public function jsonSerialize() {
        return array_merge(parent::jsonSerialize(),[
            "quantity" => $this->quantity]);
    }

    public function setQuantity($quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getMaxQuantity()
    {
        return $this->maxQuantity;
    }

    public function getQuantity() {
        return $this->quantity;
    }




}
