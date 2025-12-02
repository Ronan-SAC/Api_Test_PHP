<?php

namespace App\Models;

class Database{
    public static function getConnection(){
        $host = $_ENV['DB_HOST'] ?? 'localhost';
        $dbname = $_ENV['DB_NAME'] ?? 'cattendance_list_db';
        $user = $_ENV['DB_USER'] ?? 'root';
        $password = $_ENV['DB_PASSWORD'] ?? '';

        $pdo = new \PDO("mysql:host=$host;dbname=$dbname", $user, $password);

        return $pdo;
    }
}