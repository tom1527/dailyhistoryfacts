<?php
    class DataBaseConn {
        private $host = "localhost";
        private $user = "root";
        private $psw = "password";
        private $dbName = "interestingfacts";

        protected function connect() {
            $dsn = "mysql:host=" . $this->host . ";dbName=" . $this->dbName;
            $pdo = new PDO($dsn, $this->user, $this->psw);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        }
    }
?>