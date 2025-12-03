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

    public static function createStudent($data) {
        $pdo = self::getConnection();
    
        $stmt = $pdo->prepare("INSERT INTO students(id, name) VALUES(:id, :name)");
        $stmt->execute([
            ':id'       => $data['id'],
            ':name'     => $data['name'],
        ]);
    
        return $stmt->rowCount() > 0 ? true : false;
    }

    public static function createClassroom($data) {
        $pdo = self::getConnection();
    
        $stmt = $pdo->prepare("INSERT INTO classrooms(id, name, description, teacher_id) VALUES(:id, :name, :description, :teacher_id)");
        $stmt->execute([
            ':id'               => $data['id'],
            ':name'             => $data['name'],
            ':description'      => $data['description'],
            ':teacher_id'       => $data['teacher_id'],
        ]);
    
        return $stmt->rowCount() > 0 ? true : false;
    }

    public static function showStudent($id) {
        $pdo = self::getConnection();
    
        $stmt = $pdo->prepare("SELECT * FROM students WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]); 
    
        if ($stmt->rowCount() == 0) return false;
    
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public static function showClassroom($id) {
        $pdo = self::getConnection();
    
        $stmt = $pdo->prepare("SELECT * FROM classrooms WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]); 
    
        if ($stmt->rowCount() == 0) return false;
    
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public static function createEnrollments($data) {
        $pdo = self::getConnection();
    
        $stmt = $pdo->prepare("INSERT INTO enrollments(id, student_id, classroom_id) VALUES(:id, :student_id, :classroom_id)");
        $stmt->execute([
            ':id'               => $data['id'],
            ':student_id'       => $data['student_id'],
            ':classroom_id'     => $data['classroom_id'],
        ]);
    
        return $stmt->rowCount() > 0 ? true : false;
    }

    public static function showEnrollment($id) {
        $pdo = self::getConnection();
    
        $stmt = $pdo->prepare("SELECT * FROM enrollments WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]); 
    
        if ($stmt->rowCount() == 0) return false;
    
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public static function createAttendance($data) {
        $pdo = self::getConnection();
    
        $stmt = $pdo->prepare("INSERT INTO attendance(id, enrollment_id, attendance_date, status, recorded_by) VALUES(:id, :enrollment_id, :attendance_date, :status, :recorded_by)");
        $stmt->execute([
            ':id'               => $data['id'],
            ':enrollment_id'    => $data['enrollment_id'],
            ':attendance_date'  => $data['attendance_date'],
            ':status'           => $data['status'],
            ':recorded_by'      => $data['recorded_by'],
        ]);
    
        return $stmt->rowCount() > 0 ? true : false;
    }

    public static function indexStudent() {
        $pdo = self::getConnection();
    
        $stmt = $pdo->prepare("SELECT * FROM students");
        $stmt->execute(); 
    
        if ($stmt->rowCount() == 0) return false;
    
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function indexClassroom() {
        $pdo = self::getConnection();
    
        $stmt = $pdo->prepare("SELECT * FROM classrooms");
        $stmt->execute(); 
    
        if ($stmt->rowCount() == 0) return false;
    
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function indexTeacher() {
        $pdo = self::getConnection();
    
        $stmt = $pdo->prepare("SELECT * FROM users WHERE role = 'teacher'");
        $stmt->execute(); 
    
        if ($stmt->rowCount() == 0) return false;
    
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function indexEnrollments() {
        $pdo = self::getConnection();
    
        $stmt = $pdo->prepare("SELECT * FROM enrollments");
        $stmt->execute(); 
    
        if ($stmt->rowCount() == 0) return false;
    
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}