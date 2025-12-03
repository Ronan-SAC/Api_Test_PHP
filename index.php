<?php
header("Access-Control-Allow-Origin: http://localhost:3000"); 
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

// Responde ao preflight OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}


require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/Routes/main.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


use App\Core\Core;
use App\Http\Route;

Core::dispatch(Route::routes());