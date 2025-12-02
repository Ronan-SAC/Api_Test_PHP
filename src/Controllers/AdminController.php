<?php

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;
use App\Services\AdminService;

class AdminController {
    public function login(Request $request, Response $response){

        $body = $request::body();

        $AdminService = AdminService::login($body);

        if (isset($AdminService['error'])) {
            $response::json([
                'error' => $AdminService['error']
            ], 400);
            return;
        }

        $response::json([
            'user' => $AdminService['data'],
            'jwt' => $AdminService['jwt']
        ], 200);
        return;
    }

    public function create(Request $request, Response $response){
        $body = $request::body();

        $authorization = $request::authorization();

        $AdminService = AdminService::create($body, $authorization);

        if (isset($AdminService['error'])) {
            $response::json([
                'error' => $AdminService['error']
            ], 400);
            return;
        }

        $response::json([
            'data' => $AdminService
        ], 201);
    }

    public function index(Request $request, Response $response){
        $authorization = $request::authorization();

        $adminService = AdminService::index($authorization);

        if (isset($adminService['unauthorized'])) {
            $response::json([
                'error' => $adminService['unauthorized']
            ], 403);
            return;
        }

        if (isset($adminService['error'])) {
            $response::json([
                'error' => $adminService['error']
            ], 400);
            return;
        }

        $response::json([
            'users' => $adminService
        ], 200);
    }

    public function show(Request $request, Response $response, $id){
        $authorization = $request::authorization();

        $adminService = AdminService::show($id[0], $authorization);

        if (isset($adminService['unauthorized'])) {
            $response::json([
                'error' => $adminService['unauthorized']
            ], 403);
            return;
        }

        if (isset($adminService['error'])) {
            $response::json([
                'error' => $adminService['error']
            ], 400);
            return;
        }

        $response::json([
            'user' => $adminService
        ], 200);

    }

    public function update(Request $request, Response $response, $id){
        $body = $request::body();

        $authorization = $request::authorization();

        $adminService = AdminService::update($id[0], $body, $authorization);

        if (isset($adminService['unauthorized'])) {
            $response::json([
                'error' => $adminService['unauthorized']
            ], 403);
            return;
        }

        if (isset($adminService['error'])) {
            $response::json([
                'error' => $adminService['error']
            ], 400);
            return;
        }

        $response::json([
            'data' => $adminService
        ], 200);
    }

    public function delete(Request $request, Response $response, $id){
        $authorization = $request::authorization();

        $adminService = AdminService::delete($id[0], $authorization);

        if (isset($adminService['unauthorized'])) {
            $response::json([
                'error' => $adminService['unauthorized']
            ], 403);
            return;
        }

        if (isset($adminService['error'])) {
            $response::json([
                'error' => $adminService['error']
            ], 400);
            return;
        }

        $response::json([
            'data' => $adminService
        ], 200);
    }
}