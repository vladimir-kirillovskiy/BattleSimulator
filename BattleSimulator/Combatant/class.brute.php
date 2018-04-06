<?php

class Brute extends AbstractCombatant {
    public function __construct($name) {
        $this->name = $name;
        $this->health = rand(90, 100);
        $this->strength = rand(65, 75);
        $this->defense = rand(40, 50);
        $this->speed = rand(40, 65);
        $this->luck = rand(3, 4) / 10;
        $this->type = 'Brute';

    }

    public function receiveBlow($damage) {
        $this->health -= $damage;
    }

    public function attack(AbstractCombatant $enemy) {
        // check if player got stunned
        if ($this->getStun()) {
            CLI::clioutDelay($this->name . " loses his chance to attack");
            $this->setStun(false);
            return false;
        }

         
        // chance to evade 
        if (rand(0, 100) <= $enemy->getLuck() * 100) {
            $evadeDamage = 10;
            CLI::clioutDelay($enemy->getName() . " evaded " . $this->getName() . "'s attack");
            return false;
        }

         // calculate damage
        $damage = $this->getStrength() - $enemy->getDefense();

        // 2% chance of stunning the enemy
        if (rand(0,99) < 2) {
            CLI::clioutDelay($enemy->name . " received stun");
            $enemy->setStun(true);
        }
        $enemy->receiveBlow($damage);
        CLI::clioutDelay($enemy->name . " received " . $damage . " damage");
        CLI::clioutDelay($enemy->name . " has " . $enemy->getHealth() . " health left");
    }
}



?>