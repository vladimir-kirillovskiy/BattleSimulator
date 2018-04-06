<?php

class Swordsman extends AbstractCombatant {
    public function __construct($name) {
        $this->name = $name;
        $this->health = rand(40, 60);
        $this->strength = rand(60, 70);
        $this->defense = rand(20, 30);
        $this->speed = rand(90, 100);
        $this->luck = rand(3, 5) / 10;
        $this->type = 'Swordsman';
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

        // 5% chance of doubling the attack
        if (rand(0,99) < 5) {
            $doubleDamage = $damage * 2;
            $enemy->receiveBlow($doubleDamage);
            CLI::clioutDelay($enemy->name . " received " . doubleDamage . " damage");
        } else {
            $enemy->receiveBlow($damage);
            CLI::clioutDelay($enemy->name . " received " . $damage . " damage");
        }
        CLI::clioutDelay($enemy->name . " has " . $enemy->getHealth() . " health left");
    }
}



?>