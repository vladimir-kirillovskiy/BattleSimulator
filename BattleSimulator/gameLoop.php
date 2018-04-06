<?php

require('class.cli.php');

require('Combatant/class.abstractCombatant.php');
require('Combatant/class.swordsman.php');
require('Combatant/class.brute.php');
require('Combatant/class.grappler.php');

class Loop {

    // constants for maintainability
    // in theory this can be changed to increase number of fighters
    // but in practice it won't work as I've codded it with 1-on-1 rules in mind
    const NUMBER_OF_FIGHTERS = 2;
    // limit number of rounds
    const ROUNDS = 30;

    // list of all combatans
    private static $combatants = array(
        'Brute',
        'Grappler',
        'Swordsman'
    );

    public function start() {
        // start game message
        CLI::clioutDelay("Welcome to the Battleground");
        // get list of fighters
        $fighters = $this->chooseFighters();
        // start game loop and pass list of fighters as parameter
        $this->mainLoop($fighters);

    }

    // function to create list of fighters
    // get name from cli and assign random combatant class to it
    // return array of fighters
    private function chooseFighters() {
        $fighters = array();

        for ($i = 0; $i < self::NUMBER_OF_FIGHTERS; ++$i) {
            $name = CLI::getLine("Enter name for the fighter " . ($i + 1) . ": ");
            // if name is longer than 30 charaters, we take just first 30
            $name = substr($name, 0, 30);
            // add random class fighter to the array
            $randIndex = rand(0, count(static::$combatants) - 1);
            $fighters[$i] = new static::$combatants[$randIndex]($name);

            CLI::clioutDelay("Fighter " . $fighters[$i]->getName() . " is a " . $fighters[$i]->getType());
        }

        return $fighters;
    }

    private function mainLoop($fighters) {
        // By default first fighter is an attacker
        $nextMove = 0;

        // The faster one should be an attacker
        if ($fighters[0]->getSpeed() < $fighters[1]->getSpeed()) {
            $nextMove = 1;
        } else if ($fighters[0]->getSpeed() == $fighters[1]->getSpeed()) {
            // or the one with lower defense
            if ($fighters[0]->getDefense() > $fighters[1]->getDefense()) {
                $nextMove = 1;
            }
        }

        CLI::clioutDelay("### Let the fight begin! ###");
        // the loop itself
        for ($i = 0; $i < self::ROUNDS; ++$i) {
            CLI::clioutDelay("### Round " . ($i + 1) . " ###");

            // allocate attacker anddefender roles for this round
            $attacker = ($nextMove == 0) ? $fighters[0] : $fighters[1];
            $defender = ($nextMove == 1) ? $fighters[0] : $fighters[1];

            $attacker->attack($defender);

            // check health for both attacker and defender 
            // as grappler can add damage while evading attack  
            if ($this->checkHealth($defender) || $this->checkHealth($attacker)) {
                CLI::clioutDelay("Game Over");
                break;
            }
            // check round and declare draw
            if ((self::ROUNDS - 1) == $i) {
                CLI::clioutDelay("Game Over. No Winner. No Looser. DRAW!!!");
            }

            // flip attacker/defender
            $nextMove = ($nextMove == 1) ? 0 : 1;
        }
        
    }

    // function to check health of a given figher
    // return bool
    // if health dropped below 0 then return true
    private function checkHealth(abstractCombatant $fighter) {
        if ($fighter->getHealth() <= 0) {
            CLI::clioutDelay($fighter->getName() . " has lost!");
            return true;
        }
        
        return false;
    }
}


?>