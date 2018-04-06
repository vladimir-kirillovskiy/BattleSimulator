<?php

abstract class AbstractCombatant {
    protected $name;
    protected $health;
    protected $strength;
    protected $defense;
    protected $speed;
    protected $luck;
    protected $type;
    protected $stun = false;

    abstract protected function receiveBlow($damage);
    abstract protected function attack(AbstractCombatant $fighter);

    public function __construct() {}

    // getters and setters
    public function getName() {
        return $this->name;
    }
    public function getHealth() {
        return $this->health;
    }
    public function getStrength() {
        return $this->strength;
    }
    public function getDefense() {
        return $this->defense;
    }
    public function getSpeed() {
        return $this->speed;
    }
    public function getLuck() {
        return $this->luck;
    }
    public function getType() {
        return $this->type;
    }
    public function getStun() {
        return $this->stun;
    }
    public function setStun($bool) {
        $this->stun = $bool;
    }
}


?>