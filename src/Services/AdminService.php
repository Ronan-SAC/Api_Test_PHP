<?php

namespace App\Services;

use App\Utils\Validator;
use App\Models\Admin;

class AdminService {

    public static function create($data){
        try{
            $fields = Validator::validate([
                'id' => uniqid(),
                'name' => $data['name'] ?? '',
                'email' => $data['email'] ?? '',
                'password' => password_hash($data['password'], PASSWORD_DEFAULT) ?? '',
                'role' => $data['role'] ?? ''
            ]);

            $adminUser = Admin::create($fields); 

            if (!$adminUser) return ['error' => 'Não foi possível criar o usuário'];

            return "Usuário criado com sucesso";
        }
        catch(\PDOException $e){
            return ['error' => $e->getMessage()];
        }
        catch(\Exception $e){
            return ['error' => $e->getMessage()];
        }
    }
}