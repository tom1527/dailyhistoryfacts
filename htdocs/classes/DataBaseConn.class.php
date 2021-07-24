<?php
    class DataBaseConn {
        private $host = "localhost";
        private $user = "root";
        private $psw = "password";
        private $dbname = "interestingfacts";

        protected function connect(): PDO {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbname;
            $pdo = new PDO($dsn, $this->user, $this->psw);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        }
    }
?>