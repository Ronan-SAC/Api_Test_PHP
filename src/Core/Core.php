<?php 

namespace App\Core;

use App\Http\Request;
use App\Http\Response;

class Core
 {
    public static function dispatch(array $routes){
        $url = '/';

        isset($_GET['url']) && $url .= $_GET['url'];

        $url !== '/' && $url = trim($url, '/');

        $routeFound = false;

        foreach($routes as $route){
            $pattern = '#^'. preg_replace('/{id}/', '([\w-]+)', $route['path']) .'$#';
            
            $prefixController = 'App\\Controllers\\';

            if ($route['method'] != Request::method()){
                Response::json(['message' => 'Method not allowed'], 405);
                return;
            }

            if (preg_match($pattern, $url, $matches)){
                array_shift($matches);

                $routeFound = true;

                [$controller, $action] = explode('@', $route['action']);

                $controller = $prefixController . $controller;
                $extendController = new $controller();
                $extendController->$action(new Request, new Response, $matches);
            };
        }

        if (!$routeFound){
            Response::json(['message' => 'Route not found'], 404);
        }
    }
}