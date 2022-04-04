<?php
    class DataBaseConn {
        private $host = "database";
        private $user = "root";
        private $psw = "KgdS8Ilbf8J3";
        private $dbname = "interestingfacts";

        protected function connect(): PDO {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbname . ";charset=utf8";
            $pdo = new PDO($dsn, $this->user, $this->psw);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        }
    }
?>
