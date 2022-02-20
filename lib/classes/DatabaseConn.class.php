<?php
    class DataBaseConn {
        private $host = "database-cluster.cluster-cb1bkopanp3s.eu-west-2.rds.amazonaws.com";
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
