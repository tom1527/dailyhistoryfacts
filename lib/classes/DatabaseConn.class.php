<?php
    class DatabaseConn {
        public static function connect(): PDO {
            $psw = getenv("MYSQL_ROOT_PASSWORD");
            $host = getEnv('ENVIRONMENT') == 'LIVE' ? "127.0.0.1" : 'database';
            $user = "root";
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
