<?php

class Grappler extends AbstractCombatant {
    public function __construct($name) {
        $this->name = $name;
        $this->health = rand(60, 100);
        $this->strength = rand(75, 80);
        $this->defense = rand(35, 40);
        $this->speed = rand(60, 80);
        $this->luck = rand(3, 4) / 10;
        $this->type = 'Grappler';
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
            $this->receiveBlow($evadeDamage);
            CLI::clioutDelay($this->name . " receives " . $evadeDamage .
                 " damage, due to Grappler's special skill");
            CLI::clioutDelay($this->name . " has " . $this->getHealth() . " health left");

            return false;
        }

        // calculate damage
        $damage = $this->getStrength() - $enemy->getDefense();

        $enemy->receiveBlow($damage);
        CLI::clioutDelay($enemy->name . " received " . $damage . " damage");
        CLI::clioutDelay($enemy->name . " has " . $enemy->getHealth() . " health left");
    }

}



?>