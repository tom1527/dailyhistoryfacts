<?php
require_once '../vendor/autoload.php';
// use DatabaseConnectionException;
    class DataBaseConn {
        public static function connect(): PDO {
            $host = getEnv('ENVIRONMENT') == 'LIVE' ? "127.0.0.1" : 'database';
            $user = "root";
            $psw = "KgdS8Ilbf8J3";
            $dbname = "interestingfacts";

            $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
            try {
                $pdo = new PDO($dsn, $user, $psw);
            } catch (PDOException $Exception) {
                throw new DatabaseConnectionException($Exception->getMessage());
            }
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        }
    }
?>
