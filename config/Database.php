<?php

namespace Config;

use PDO;
use PDOException;

class Database 
{
    private static $host = 'localhost';
    private static $db_name = 'movieloc_db';
    private static $username = 'root';
    private static $password = '';
    private static $conn = null;

    public static function getConnection() 
    {
        if (self::$conn === null) {
            try {
                self::$conn = new PDO(
                    "mysql:host=" . self::$host . ";dbname=" . self::$db_name . ";charset=utf8",
                    self::$username,
                    self::$password
                );
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die("Erro na conexão: " . $e->getMessage());
            }
        }
        return self::$conn;
    }
}