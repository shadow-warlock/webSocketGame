<?php


namespace WebSocketGame\Model;

use JsonSerializable;
use WebSocketGame\Utilities;

class GameObject implements JsonSerializable{
    protected $name;
    protected $coordinates = [
        "x" => 0,
        "y" => 0,
    ];
    protected $radius;

    public function __construct($name, $x, $y, $radius){
        $this->name=$name;
        $this->coordinates["x"]=$x;
        $this->coordinates["y"]=$y;
        $this->radius=$radius;
    }

    public function jsonSerialize() {
        return [
            "name" => $this->name,
            "coordinates" => $this->coordinates,
            "radius" => $this->radius];
    }

    public function radiusCheck($x,$y): bool{
        return Utilities::radiusCheck($x,$this->getCoordinates()["x"],$y,$this->getCoordinates()["y"],$this->radius);
    }

    public function getCoordinates(): array{
        return $this->coordinates;
    }
}
