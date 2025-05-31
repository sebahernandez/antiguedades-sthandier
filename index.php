<?php
// Cargar configuración
require_once './config/config.php';

// Configuración de headers CORS
header("Access-Control-Allow-Origin: " . Config::CORS_ORIGINS);
header("Access-Control-Allow-Methods: " . Config::CORS_METHODS);
header("Access-Control-Allow-Headers: " . Config::CORS_HEADERS);
header("Content-Type: application/json; charset=UTF-8");

// Manejar preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Manejo de errores global
if (Config::SHOW_ERRORS) {
    set_error_handler(function($errno, $errstr, $errfile, $errline) {
        error_log("PHP Error: $errstr in $errfile on line $errline");
        http_response_code(500);
        echo json_encode([
            "mensaje" => "Error interno del servidor",
            "error" => Config::DEBUG_MODE ? "$errstr in $errfile:$errline" : "Error interno"
        ]);
        exit();
    });
}

// Incluir las rutas
require_once './routes/routes.php';