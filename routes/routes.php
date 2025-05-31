<?php
require_once './controllers/ProductoController.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];

try {
    $controller = new ProductoController();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["mensaje" => "Error interno del servidor", "error" => $e->getMessage()]);
    exit();
}

// Parsear el ID si existe en la URL
$uri = parse_url($requestUri, PHP_URL_PATH);
$uriParts = explode('/', trim($uri, '/'));

// Método 1: Usar query parameters (?route=productos&id=1)
$route = $_GET['route'] ?? null;
$id = $_GET['id'] ?? null;

// Método 2: Si no hay query params, intentar parsear la URL
if (!$route) {
    // Remover el directorio base si existe (antiguedades-backend)
    if (!empty($uriParts) && $uriParts[0] === 'antiguedades-backend') {
        array_shift($uriParts);
    }
    
    // Si accede directamente al index.php, removerlo también
    if (!empty($uriParts) && $uriParts[0] === 'index.php') {
        array_shift($uriParts);
    }
    
    $route = $uriParts[0] ?? null;
    $id = $uriParts[1] ?? null;
}

$recurso = $route;

// Rutas principales
if ($recurso === 'productos') {
    switch ($requestMethod) {
        case 'GET':
            if ($id) {
                $controller->obtenerPorId($id);
            } else {
                $controller->obtenerTodos();
            }
            break;

        case 'POST':
            $datos = json_decode(file_get_contents("php://input"), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                http_response_code(400);
                echo json_encode(["mensaje" => "JSON inválido"]);
                break;
            }
            $controller->crear($datos);
            break;

        case 'PUT':
            if ($id) {
                $datos = json_decode(file_get_contents("php://input"), true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    http_response_code(400);
                    echo json_encode(["mensaje" => "JSON inválido"]);
                    break;
                }
                $controller->actualizar($id, $datos);
            } else {
                http_response_code(400);
                echo json_encode(["mensaje" => "ID requerido para actualizar"]);
            }
            break;

        case 'DELETE':
            if ($id) {
                $controller->eliminar($id);
            } else {
                http_response_code(400);
                echo json_encode(["mensaje" => "ID requerido para eliminar"]);
            }
            break;

        case 'PATCH':
            // Verificar si es una operación de reserva usando query parameter
            $action = $_GET['action'] ?? null;
            if ($id && $action === 'reservar') {
                $datos = json_decode(file_get_contents("php://input"), true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    http_response_code(400);
                    echo json_encode(["mensaje" => "JSON inválido"]);
                    break;
                }
                $controller->reservarProducto($id);
            } else {
                http_response_code(400);
                echo json_encode(["mensaje" => "Ruta PATCH inválida. Use ?route=productos&id={id}&action=reservar"]);
            }
            break;

        default:
            http_response_code(405);
            echo json_encode(["mensaje" => "Método no permitido"]);
    }
} else {
    http_response_code(404);
    echo json_encode(["mensaje" => "Ruta no encontrada"]);
}
