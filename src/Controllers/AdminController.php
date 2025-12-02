<?php

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;

class AdminController {
    public function login(Request $request, Response $response){

    }

    public function create(Request $request, Response $response){
        $body = $request::body();

        $response::json([
            'data' => $body
        ], 201);
    }

    public function index(Request $request, Response $response){

    }

    public function show(Request $request, Response $response){

    }

    public function delete(Request $request, Response $response){

    }
}