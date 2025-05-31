<?php
// CORS Handler Ultra-Robusto - DEBE ejecutarse PRIMERO
require_once './cors-handler.php';

// Cargar configuración
require_once './config/config.php';

// CONFIGURACIÓN CORS ULTRA-ROBUSTA PARA SWAGGER UI
// Establecer headers CORS antes de cualquier output
if (function_exists('header_remove')) {
    header_remove('X-Powered-By');
}

// Headers CORS obligatorios
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization, Cache-Control");
header("Access-Control-Allow-Credentials: false"); // Cambiar a false para mayor compatibilidad
header("Access-Control-Max-Age: 86400");

// Headers adicionales para mejor compatibilidad
header("Content-Type: application/json; charset=UTF-8");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

// Manejar preflight requests de forma ULTRA-ROBUSTA
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Headers adicionales específicos para preflight
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS");
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization, Cache-Control");
    header("Access-Control-Max-Age: 86400");
    header("Content-Length: 0");
    
    // Log detallado para debugging
    $origin = $_SERVER['HTTP_ORIGIN'] ?? 'sin origen';
    $method = $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'] ?? 'sin método';
    $headers = $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'] ?? 'sin headers';
    
    error_log("CORS Preflight - Origen: $origin, Método: $method, Headers: $headers");
    
    // Respuesta exitosa y salir
    http_response_code(200);
    exit(0);
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