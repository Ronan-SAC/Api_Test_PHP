<?php

namespace App\Services;

use App\Utils\Validator;
use App\Models\Admin;
use App\Http\JWT;

class AdminService {

    public static function create($data, $authorization){
        try{
            if (isset($authorization['error'])) return ['error' => $authorization['error']];

            $adminUser = JWT::verify($authorization);

            if (!$adminUser) return ['unauthorized' => 'Usuário não autenticado'];

            if ($adminUser['role'] != 'admin') return ['unauthorized' => 'Você não tem permissão para fazer essa requisição'];

            $fields = Validator::validate([
                'id' => uniqid(),
                'name' => $data['name'] ?? '',
                'email' => $data['email'] ?? '',
                'password' => $data['password'] ?? '',
                'role' => $data['role'] ?? ''
            ]);

            $fields['password'] = password_hash($fields['password'], PASSWORD_DEFAULT);

            $adminUser = Admin::create($fields); 

            if (!$adminUser) return ['error' => 'Não foi possível criar o usuário'];

            return ['success' => 'Usuário criado com sucesso'];
        }
        catch(\PDOException $e){
            if ($e->getCode() == 23000) return ['error' => 'Email já cadastrado'];
            return ['error' => $e->getMessage()];
        }
        catch(\Exception $e){
            return ['error' => $e->getMessage()];
        }
    }

    public static function login($data){
        try{
            $fields = Validator::validate([
                'email' => $data['email'] ?? '',
                'password' => $data['password'] ?? ''
            ]);

            $adminUser = Admin::login($fields); 

            if (!$adminUser) return ['error' => 'Usuário não autenticado'];

            return ['jwt' => JWT::generate($adminUser), 'data' => $adminUser];
        }
        catch(\PDOException $e){
            return ['error' => $e->getMessage()];
        }
        catch(\Exception $e){
            return ['error' => $e->getMessage()];
        }
    }

    public static function index($authorization){
        try{
            if (isset($authorization['error'])) return ['error' => $authorization['error']];

            $adminUser = JWT::verify($authorization);

            if (!$adminUser) return ['unauthorized' => 'Usuário nao autenticado'];

            if ($adminUser['role'] != 'admin') return ['unauthorized' => 'Você não tem permissão para fazer essa requisição'];

            $allUsers = Admin::index();

            return $allUsers;
        }
        catch(\PDOException $e){
            return ['error' => $e->getMessage()];
        }
        catch(\Exception $e){
            return ['error' => $e->getMessage()];

    }
    }

    public static function show($id, $authorization){
        try{
            if (isset($authorization['error'])) return ['error' => $authorization['error']];

            $adminUser = JWT::verify($authorization);

            if (!$adminUser) return ['unauthorized' => 'Usuário nao autenticado'];

            if ($adminUser['role'] != 'admin') return ['unauthorized' => 'Você não tem permissão para fazer essa requisição'];

            $user = Admin::show(id: $id);

            if (!$user) return ['error' => 'Usuário não existe'];

            return $user;
        }
        catch(\PDOException $e){
            return ['error' => $e->getMessage()];
        }
        catch(\Exception $e){
            return ['error' => $e->getMessage()];
    }
    }

    public static function update($id, $data, $authorization){
        try{
            if (isset($authorization['error'])) return ['error' => $authorization['error']];

            $adminUser = JWT::verify($authorization);

            if (!$adminUser) return ['unauthorized' => 'Usuário nao autenticado'];

            if ($adminUser['role'] != 'admin') return ['unauthorized' => 'Você não tem permissão para fazer essa requisição'];

            $fields = Validator::validate([
                'name' => $data['name'] ?? '',
                'email' => $data['email'] ?? '',
                'password' => $data['password'] ?? '',
                'role' => $data['role'] ?? ''
            ]);

            $fields['password'] = password_hash($fields['password'], PASSWORD_DEFAULT);

            $adminUser = Admin::update($fields, $id);

            if (!$adminUser) return ['error' => 'Usuário nao atualizado'];

            return ['success' => 'Usuário atualizado com sucesso'];
        }
        catch(\PDOException $e){
            if ($e->getCode() == 23000) return ['error' => 'Email já cadastrado'];
            return ['error' => $e->getMessage()];
        }
        catch(\Exception $e){
            return ['error' => $e->getMessage()];
        }
    }

    public static function delete($id, $authorization){
        try{
            if (isset($authorization['error'])) return ['error' => $authorization['error']];

            $adminUser = JWT::verify($authorization);

            if (!$adminUser) return ['unauthorized' => 'Usuário nao autenticado'];

            if ($adminUser['role'] != 'admin') return ['unauthorized' => 'Você não tem permissão para fazer essa requisição'];

            $adminUser = Admin::delete($id);

            if (!$adminUser) return ['error' => 'Usuário nao deletado'];

            return ['success' => 'Usuário deletado com sucesso'];
        }
        catch(\PDOException $e){
            return ['error' => $e->getMessage()];
        }
        catch(\Exception $e){
            return ['error' => $e->getMessage()];
        }
    }
}
