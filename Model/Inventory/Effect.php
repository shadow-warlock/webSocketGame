<?php


namespace WebSocketGame\Model\Inventory;


class Effect {

    private $parameter;
    private $values;

    /**
     * Effect constructor.
     * @param $parameter
     * @param $value
     */
    public function __construct($parameter, $values) {
        $this->parameter = $parameter;
        $this->values = $values;
    }

    /**
     * @return mixed
     */
    public function getParameter() {
        return $this->parameter;
    }

    /**
     * @return mixed
     */
    public function getValues() {
        return $this->values;
    }



}
