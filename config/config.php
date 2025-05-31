<?php
// Configuración global de la aplicación
class Config {
    // Configuración del servidor
    const BASE_URL = 'http://localhost:8888';
    const PROJECT_PATH = '/antiguedades-backend';
    const FULL_BASE_URL = self::BASE_URL . self::PROJECT_PATH;
    
    // Configuración de la base de datos
    const DB_HOST = 'localhost';
    const DB_PORT = '8889';
    const DB_NAME = 'artesanias';
    const DB_USER = 'root';
    const DB_PASS = 'root';
    
    // Headers CORS
    const CORS_ORIGINS = '*';
    const CORS_METHODS = 'GET, POST, PUT, DELETE, PATCH, OPTIONS';
    const CORS_HEADERS = 'Content-Type, Authorization';
    
    // Configuración de desarrollo
    const DEBUG_MODE = true;
    const SHOW_ERRORS = true;
}
?>
