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

    public static function login($data) {
        $pdo = self::getConnection();
    
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $data['email']]); 
    
        if ($stmt->rowCount() == 0) return false;
    
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
    
        if (!password_verify($data['password'], $user['password'])) return false;
    
        return ['id' => $user['id'], 'name' => $user['name'], 'email' => $user['email'], 'role' => $user['role']];
    }

    public static function show($id) {
        $pdo = self::getConnection();
    
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]); 
    
        if ($stmt->rowCount() == 0) return false;
    
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public static function index() {
        $pdo = self::getConnection();
    
        $stmt = $pdo->prepare("SELECT * FROM users");
        $stmt->execute(); 
    
        if ($stmt->rowCount() == 0) return false;
    
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function update($data, $id){
        $pdo = self::getConnection();

        $stmt = $pdo->prepare("UPDATE users SET name = :name, email = :email, password = :password, role = :role WHERE id = :id");
        $stmt->execute([
            ':id'       => $id,
            ':name'     => $data['name'],
            ':email'    => $data['email'],
            ':password' => $data['password'],
            ':role'     => $data['role'],
        ]);
        
        return $stmt->rowCount() > 0 ? true : false;
    }

    public static function delete($id) {
        $pdo = self::getConnection();
    
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]); 
    
        return $stmt->rowCount() > 0 ? true : false;
    }
}