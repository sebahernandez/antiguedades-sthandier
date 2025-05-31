<?php
require_once './config/database.php';

class ProductoController {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // GET /productos
    public function obtenerTodos() {
        $query = "SELECT * FROM productos";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($productos);
    }

    // GET /productos/{id}
    public function obtenerPorId($id) {
        $query = "SELECT * FROM productos WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $producto = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($producto) {
            echo json_encode($producto);
        } else {
            http_response_code(404);
            echo json_encode(["mensaje" => "Producto no encontrado"]);
        }
    }

    // POST /productos
    public function crear($datos) {
        // Validar que los datos requeridos estén presentes
        if (!isset($datos['nombre']) || !isset($datos['precio'])) {
            http_response_code(400);
            echo json_encode(["mensaje" => "Faltan datos requeridos: nombre y precio"]);
            return;
        }

        // Establecer valores por defecto
        $datos['estado_reserva'] = $datos['estado_reserva'] ?? 'disponible';
        $datos['descripcion'] = $datos['descripcion'] ?? '';
        $datos['categoria'] = $datos['categoria'] ?? 'general';

        $query = "INSERT INTO productos (nombre, descripcion, precio, categoria, estado_reserva)
                  VALUES (:nombre, :descripcion, :precio, :categoria, :estado_reserva)";
        $stmt = $this->conn->prepare($query);
        
        try {
            if ($stmt->execute($datos)) {
                http_response_code(201);
                $lastId = $this->conn->lastInsertId();
                echo json_encode([
                    "mensaje" => "Producto creado exitosamente",
                    "id" => $lastId
                ]);
            } else {
                http_response_code(400);
                echo json_encode(["mensaje" => "Error al crear producto"]);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["mensaje" => "Error de base de datos: " . $e->getMessage()]);
        }
    }

    // PUT /productos/{id}
    public function actualizar($id, $datos) {
        $query = "UPDATE productos SET nombre = :nombre, descripcion = :descripcion, precio = :precio, categoria = :categoria, estado_reserva = :estado_reserva WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $datos['id'] = $id; // Agregar el id a los datos

        if ($stmt->execute($datos)) {
            echo json_encode(["mensaje" => "Producto actualizado exitosamente"]);
        } else {
            http_response_code(400);
            echo json_encode(["mensaje" => "Error al actualizar producto"]);
        }
    }

    // DELETE /productos/{id}
    public function eliminar($id) {
        $query = "DELETE FROM productos WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            echo json_encode(["mensaje" => "Producto eliminado correctamente"]);
        } else {
            http_response_code(400);
            echo json_encode(["mensaje" => "Error al eliminar producto"]);
        }
    }

    // PATCH /productos/{id}/reservar
    public function reservarProducto($id) {
        $input = json_decode(file_get_contents("php://input"), true);
        $estado = $input['estado_reserva'] ?? null;

        if (!in_array($estado, ['reservado', 'disponible'])) {
            http_response_code(400);
            echo json_encode(["mensaje" => "Estado de reserva inválido"]);
            return;
        }

        $query = "UPDATE productos SET estado_reserva = :estado WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            echo json_encode(["mensaje" => "Estado de reserva actualizado"]);
        } else {
            http_response_code(500);
            echo json_encode(["mensaje" => "Error al actualizar estado"]);
        }
    }
}
