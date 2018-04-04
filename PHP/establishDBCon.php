<?php
header('Access-Control-Allow-Origin:*');

function establishDatabaseConnection($hostname,$database,$username,$password) {
        $db_charset = "utf8mb4";
        $dsn = "mysql:host=$hostname;dbname=$database;charset=$db_charset";
        $opt = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        );
        try {
            return new PDO($dsn, $username, $password, $opt);
        } catch (PDOException $e) {
            exit("Cannot establish connection with DB");
        }
    }
?>