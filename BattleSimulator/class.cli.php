<?php

    // check if application was oppened not from cli
    if (!defined('STDIN')) {
        echo "This application for cli use only";
        exit;
    }

    // simple class to manage cli input/output
    class CLI {
        // get string input
        public static function getLine($prompt = '') {
            echo $prompt;
            return trim(fgets(STDIN));
        }

        // get int input
        public static function getInt($prompt = '') {
            echo $prompt;
            $input = (int) trim(fgets(STDIN));
            return is_numeric($input) ? $input : false;
        }

        // output string with 1 second delay 
        // to make a gameplay a bit more interesting
        public static function clioutDelay($text = '') {
            sleep(1);
            echo $text . "\n";
        }

        // output string
        public static function cliout($text = '') {
            echo $text . "\n";
        }
    }

?>