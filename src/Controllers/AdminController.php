<?php

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;
use App\Services\AdminService;

class AdminController {
    public function login(Request $request, Response $response){

    }

    public function create(Request $request, Response $response){
        $body = $request::body();

        $AdminService = AdminService::create($body);

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

    }

    public function show(Request $request, Response $response){

    }

    public function delete(Request $request, Response $response){

    }
}