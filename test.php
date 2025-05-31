<?php
// Script de prueba para verificar la conexión y las rutas
require_once './config/database.php';

echo "<h2>🧪 Pruebas del Sistema</h2>";

// 1. Prueba de conexión a la base de datos
echo "<h3>1. Conexión a la base de datos:</h3>";
try {
    $db = new Database();
    $conn = $db->connect();
    
    if ($conn) {
        echo "✅ Conexión exitosa a la base de datos<br>";
        
        // Verificar si la tabla productos existe
        $stmt = $conn->query("SHOW TABLES LIKE 'productos'");
        if ($stmt->rowCount() > 0) {
            echo "✅ Tabla 'productos' encontrada<br>";
        } else {
            echo "⚠️ Tabla 'productos' no encontrada<br>";
        }
    } else {
        echo "❌ Error de conexión<br>";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

// 2. Verificar archivos del sistema
echo "<h3>2. Verificación de archivos:</h3>";
$archivos = [
    './index.php' => 'Archivo principal',
    './routes/routes.php' => 'Archivo de rutas',
    './controllers/ProductoController.php' => 'Controlador de productos',
    './config/database.php' => 'Configuración de base de datos'
];

foreach ($archivos as $archivo => $descripcion) {
    if (file_exists($archivo)) {
        echo "✅ $descripcion: $archivo<br>";
    } else {
        echo "❌ $descripcion: $archivo (no encontrado)<br>";
    }
}

// 3. Información del servidor
echo "<h3>3. Información del servidor:</h3>";
echo "📍 Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "📍 Current Directory: " . __DIR__ . "<br>";
echo "📍 PHP Version: " . phpversion() . "<br>";

// 4. Prueba de rutas simulada
echo "<h3>4. Estructura de rutas esperada:</h3>";
echo "📋 GET http://localhost:8888/antiguedades-backend/productos - Obtener todos los productos<br>";
echo "📋 GET http://localhost:8888/antiguedades-backend/productos/{id} - Obtener un producto específico<br>";
echo "📋 POST http://localhost:8888/antiguedades-backend/productos - Crear nuevo producto<br>";
echo "📋 PUT http://localhost:8888/antiguedades-backend/productos/{id} - Actualizar producto completo<br>";
echo "📋 DELETE http://localhost:8888/antiguedades-backend/productos/{id} - Eliminar producto<br>";
echo "📋 PATCH http://localhost:8888/antiguedades-backend/productos/{id}/reservar - Cambiar estado de reserva<br>";

// 5. Información de configuración MAMP
echo "<h3>5. Configuración MAMP:</h3>";
echo "🌐 URL Base: http://localhost:8888<br>";
echo "📁 Directorio del proyecto: /antiguedades-backend<br>";
echo "🗄️ Puerto MySQL: 8889<br>";
echo "📊 Base de datos: artesanias<br>";
?>
