<?php
    class DataBaseConn {
        private $host = "wamptest-website_db_1";
        private $user = "root";
        private $psw = "KgdS8Ilbf8J3";
        private $dbname = "interestingfacts";

        protected function connect(): PDO {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbname;
            $pdo = new PDO($dsn, $this->user, $this->psw);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        }
    }
?>
