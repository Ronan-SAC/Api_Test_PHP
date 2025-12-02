<?php

namespace App\Models;

use App\Models\Database;

class Admin extends Database
{
    public static function create($data){
        $pdo = self::getConnection();

        $stmt = $pdo->prepare("INSERT INTO users(id, name, email, password, role) VALUES(:id, :name, :email, :password, :role)");
        $stmt->execute([
            ':id'       => $data['id'],
            ':name'     => $data['name'],
            ':email'    => $data['email'],
            ':password' => $data['password'],
            ':role'     => $data['role'],
        ]);

        return $stmt->rowCount() > 0;
    }
}