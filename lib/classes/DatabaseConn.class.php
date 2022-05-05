<?php
    class DataBaseConn {
        protected function connect(): PDO {
            $host = getEnv('ENVIRONMENT') == 'LIVE' ? "127.0.0.1" : 'database';
            $user = "root";
            $psw = "KgdS8Ilbf8J3";
            $dbname = "interestingfacts";

            $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
            $pdo = new PDO($dsn, $user, $psw);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        }
    }
?>
