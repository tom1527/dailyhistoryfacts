<!DOCTYPE HTML>

<?php
    class Results {
        protected $info = "this is some info";

        public function dump() {
           $dump = $this->info;
           return $dump;
        }   
        
    }

    $displayResults = new results();
    echo $displayResults->dump();

    echo "<br>";

    class Person {
        private $name;
        private $eyeColour;
        private $age;
        public static $drinkingAge = 21;
        

        public function __construct($name, $eyeColour, $age) {
            $this->name = $name;
            $this->eyeColour = $eyeColour;
            $this->age = $age;
        }

        public function setName(string $name) {
            $this->name = $name;
            return $name;
        }

        public function getName(){
            return $this->name;
        }

        public static function setDrinkingAge($newDA){
            self::$drinkingAge = $newDA;
        }
            
        public function __destruct() {
            echo "<br> This is the end of the class!";
        }
    }

    $tom = new person("Tom", "blue", 22);
    echo $tom->getName();
    echo person :: $drinkingAge;
    person :: setDrinkingAge(18);
    echo person :: $drinkingAge



?>