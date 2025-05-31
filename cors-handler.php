<?php
/**
 * CORS Handler Ultra-Robusto para Swagger UI
 * Este archivo maneja específicamente los problemas de CORS
 * que pueden surgir con Swagger UI en navegadores web
 */

// Función para establecer headers CORS de forma robusta
function setCORSHeaders() {
    // Remover headers que puedan interferir
    if (function_exists('header_remove')) {
        header_remove('X-Powered-By');
        header_remove('Server');
    }
    
    // Headers CORS principales - OBLIGATORIOS
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS");
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization, Cache-Control");
    header("Access-Control-Max-Age: 86400");
    
    // Headers adicionales para mejor compatibilidad
    header("Access-Control-Allow-Credentials: false");
    header("Vary: Origin, Access-Control-Request-Method, Access-Control-Request-Headers");
    
    // Headers de respuesta
    header("Content-Type: application/json; charset=UTF-8");
    header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");
}

// Función para manejar preflight requests
function handlePreflightRequest() {
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        setCORSHeaders();
        
        // Headers específicos para preflight
        header("Content-Length: 0");
        
        // Log detallado para debugging
        $logData = [
            'timestamp' => date('Y-m-d H:i:s'),
            'origin' => $_SERVER['HTTP_ORIGIN'] ?? 'no-origin',
            'method' => $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'] ?? 'no-method',
            'headers' => $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'] ?? 'no-headers',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'no-user-agent'
        ];
        
        error_log("CORS Preflight: " . json_encode($logData));
        
        // Respuesta exitosa
        http_response_code(200);
        exit(0);
    }
}

// Función para logging de requests CORS
function logCORSRequest() {
    $logData = [
        'timestamp' => date('Y-m-d H:i:s'),
        'method' => $_SERVER['REQUEST_METHOD'],
        'uri' => $_SERVER['REQUEST_URI'],
        'origin' => $_SERVER['HTTP_ORIGIN'] ?? 'no-origin',
        'referer' => $_SERVER['HTTP_REFERER'] ?? 'no-referer',
        'user_agent' => substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 100)
    ];
    
    error_log("CORS Request: " . json_encode($logData));
}

// Ejecutar configuración CORS
setCORSHeaders();
handlePreflightRequest();

// Log solo en modo debug
if (defined('Config::DEBUG_MODE') && Config::DEBUG_MODE) {
    logCORSRequest();
}

?>
