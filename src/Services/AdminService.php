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

    public static function createStudent($data, $authorization){
        try{
            if (isset($authorization['error'])) return ['error' => $authorization['error']];

            $adminUser = JWT::verify($authorization);

            if (!$adminUser) return ['unauthorized' => 'Estudante nao autenticado'];

            if ($adminUser['role'] != 'admin') return ['unauthorized' => 'Você não tem permissão para fazer essa requisição'];

            $fields = Validator::validate([
                'id' => uniqid(),
                'name' => $data['name'] ?? '',
            ]);

            $adminUser = Admin::createStudent($fields);

            if (!$adminUser) return ['error' => 'Estudante nao cadastrado'];

            return ['success' => 'Estudante cadastrado com sucesso'];
        }
        catch(\PDOException $e){
            if ($e->getCode() == 23000) return ['error' => 'Estudante já cadastrado'];
            return ['error' => $e->getMessage()];
        }
        catch(\Exception $e){
            return ['error' => $e->getMessage()];
        }
    }

    public static function createClassroom($data, $authorization){
        try{
            if (isset($authorization['error'])) return ['error' => $authorization['error']];

            $adminUser = JWT::verify($authorization);

            if (!$adminUser) return ['unauthorized' => 'Classroom nao autenticado'];

            if ($adminUser['role'] != 'admin') return ['unauthorized' => 'Você não tem permissão para fazer essa requisição'];

            $fields = Validator::validate([
                'id' => uniqid(),
                'name' => $data['name'] ?? '',
                'description' => $data['description'] ?? '',
                'teacher_id' => $data['teacher_id'] ?? ''
            ]);

            $teacherUser = Admin::show(id: $fields['teacher_id']);

            if(!$teacherUser) return ['error' => 'Professor não cadastrado'];

            if ($teacherUser['role'] != 'teacher') return ['error' => 'Usuario não é professor'];

            $adminUser = Admin::createClassroom($fields);

            if (!$adminUser) return ['error' => 'Classroom nao cadastrado'];

            return ['success' => 'Classroom cadastrado com sucesso'];
        }
        catch(\PDOException $e){
            if ($e->getCode() == 23000) return ['error' => 'Classroom já cadastrado'];
            return ['error' => $e->getMessage()];
        }
        catch(\Exception $e){
            return ['error' => $e->getMessage()];
        }
    }

    public static function createEnrollments($data, $authorization){
        try{
            if (isset($authorization['error'])) return ['error' => $authorization['error']];

            $adminUser = JWT::verify($authorization);

            if (!$adminUser) return ['unauthorized' => 'Matricula nao autenticado'];

            if ($adminUser['role'] != 'admin') return ['unauthorized' => 'Você não tem permissão para fazer essa requisição'];

            $fields = Validator::validate([
                'id' => uniqid(),
                'student_id' => $data['student_id'] ?? '',
                'classroom_id' => $data['classroom_id'] ?? ''
            ]);

            $studentUser = Admin::showStudent(id: $fields['student_id']);

            if(!$studentUser) return ['error' => 'Estudante nao cadastrado'];

            $classroomUser = Admin::showClassroom(id: $fields['classroom_id']);

            if(!$classroomUser) return ['error' => 'Classe nao cadastrado'];

            $adminUser = Admin::createEnrollments($fields);

            if (!$adminUser) return ['error' => 'Matricula nao cadastrada'];

            return ['success' => 'Matricula cadastrada com sucesso'];
        }
        catch(\PDOException $e){
            if ($e->getCode() == 23000) return ['error' => 'Matricula já cadastrada'];
            return ['error' => $e->getMessage()];
        }
        catch(\Exception $e){
            return ['error' => $e->getMessage()];
        }
    }

    public static function createAttendance($data, $authorization){
        try{
            if (isset($authorization['error'])) return ['error' => $authorization['error']];

            $adminUser = JWT::verify($authorization);

            if (!$adminUser) return ['unauthorized' => 'Presença nao autenticado'];

            if ($adminUser['role'] != 'admin') return ['unauthorized' => 'Você não tem permissão para fazer essa requisição'];

            $fields = Validator::validate([
                'id' => uniqid(),
                'enrollment_id' => $data['enrollment_id'] ?? '',
                'attendance_date' => $data['attendance_date'] ?? '',
                'status' => $data['status'] ?? '',
                'recorded_by' => $data['recorded_by'] ?? ''
            ]);

            $enrollment = Admin::showEnrollment(id: $fields['enrollment_id']);

            if(!$enrollment) return ['error' => 'Matricula nao cadastrado'];

            $teacher = Admin::show(id: $fields['recorded_by']);

            if(!$teacher) return ['error' => 'Professor nao cadastrado'];

            if($teacher['role'] != 'teacher') return ['error' => 'Usuario nao é professor'];

            $adminUser = Admin::createAttendance($fields);

            if (!$adminUser) return ['error' => 'Presença nao cadastrada'];

            return ['success' => 'Presença cadastrada com sucesso'];
        }
        catch(\PDOException $e){
            if ($e->getCode() == 23000) return ['error' => 'Presença já cadastrada'];
            return ['error' => $e->getMessage()];
        }
        catch(\Exception $e){
            return ['error' => $e->getMessage()];
        }
    }

    public static function indexStudent($authorization){
        try{
            if (isset($authorization['error'])) return ['error' => $authorization['error']];

            $adminUser = JWT::verify($authorization);

            if (!$adminUser) return ['unauthorized' => 'Estudante nao autenticado'];

            if ($adminUser['role'] != 'admin') return ['unauthorized' => ' Você não tem permissão para fazer essa requisição'];

            return Admin::indexStudent();
        }
        catch(\PDOException $e){
            return ['error' => $e->getMessage()];
        }
        catch(\Exception $e){
            return ['error' => $e->getMessage()];
        }
    }

    public static function indexClassroom($authorization){
        try{
            if (isset($authorization['error'])) return ['error' => $authorization['error']];

            $adminUser = JWT::verify($authorization);

            if (!$adminUser) return ['unauthorized' => 'Classe nao autenticado'];

            if ($adminUser['role'] != 'admin') return ['unauthorized' => ' Vocé não tem permissão para fazer essa requisição'];

            return Admin::indexClassroom();
        }
        catch(\PDOException $e){
            return ['error' => $e->getMessage()];
        }
        catch(\Exception $e){
            return ['error' => $e->getMessage()];
        }
    }

    public static function indexTeacher($authorization){
        try{
            if (isset($authorization['error'])) return ['error' => $authorization['error']];

            $adminUser = JWT::verify($authorization);

            if (!$adminUser) return ['unauthorized' => 'Professor nao autenticado'];

            if ($adminUser['role'] != 'admin') return ['unauthorized' => ' Vocé não tem permissão para fazer essa requisição'];

            return Admin::indexTeacher();
        }
        catch(\PDOException $e){
            return ['error' => $e->getMessage()];
        }
        catch(\Exception $e){
            return ['error' => $e->getMessage()];
        }
    }

    public static function indexEnrollments($authorization){
        try{
            if (isset($authorization['error'])) return ['error' => $authorization['error']];

            $adminUser = JWT::verify($authorization);

            if (!$adminUser) return ['unauthorized' => 'Matricula nao autenticado'];

            if ($adminUser['role'] != 'admin') return ['unauthorized' => ' Vocé não tem permissão para fazer essa requisição'];

            return Admin::indexEnrollments();
        }
        catch(\PDOException $e){
            return ['error' => $e->getMessage()];
        }
        catch(\Exception $e){
            return ['error' => $e->getMessage()];
        }
    }
}
