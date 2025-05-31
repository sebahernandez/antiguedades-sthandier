<?php
// Script de diagnóstico detallado para MAMP
require_once './config/config.php';

echo "<h2>🔍 Diagnóstico Detallado del Sistema</h2>";

// 1. Verificar configuración de PHP
echo "<h3>1. Configuración de PHP:</h3>";
echo "📍 Versión PHP: " . phpversion() . "<br>";
echo "📍 PDO MySQL disponible: " . (extension_loaded('pdo_mysql') ? '✅ Sí' : '❌ No') . "<br>";
echo "📍 Current Directory: " . __DIR__ . "<br>";

// 2. Verificar configuración de la base de datos
echo "<h3>2. Configuración de Base de Datos:</h3>";
echo "📍 Host: " . Config::DB_HOST . "<br>";
echo "📍 Puerto: " . Config::DB_PORT . "<br>";
echo "📍 Base de datos: " . Config::DB_NAME . "<br>";
echo "📍 Usuario: " . Config::DB_USER . "<br>";

// 3. Intentar conexión paso a paso
echo "<h3>3. Prueba de Conexión:</h3>";

try {
    // Paso 1: Conexión básica sin especificar base de datos
    echo "🔄 Intentando conexión básica a MySQL...<br>";
    $dsn_basic = "mysql:host=" . Config::DB_HOST . ";port=" . Config::DB_PORT;
    $pdo_basic = new PDO($dsn_basic, Config::DB_USER, Config::DB_PASS);
    echo "✅ Conexión básica a MySQL exitosa<br>";
    
    // Paso 2: Listar bases de datos disponibles
    echo "🔄 Listando bases de datos disponibles...<br>";
    $stmt = $pdo_basic->query("SHOW DATABASES");
    $databases = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "📋 Bases de datos encontradas: " . implode(', ', $databases) . "<br>";
    
    // Paso 3: Verificar si existe la base de datos específica
    if (in_array(Config::DB_NAME, $databases)) {
        echo "✅ Base de datos '" . Config::DB_NAME . "' encontrada<br>";
        
        // Paso 4: Conectar a la base de datos específica
        echo "🔄 Conectando a la base de datos específica...<br>";
        $dsn_full = "mysql:host=" . Config::DB_HOST . ";port=" . Config::DB_PORT . ";dbname=" . Config::DB_NAME;
        $pdo_full = new PDO($dsn_full, Config::DB_USER, Config::DB_PASS);
        $pdo_full->exec("set names utf8");
        echo "✅ Conexión a la base de datos específica exitosa<br>";
        
        // Paso 5: Verificar tablas
        echo "🔄 Verificando tablas...<br>";
        $stmt = $pdo_full->query("SHOW TABLES");
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        if (empty($tables)) {
            echo "⚠️ No se encontraron tablas en la base de datos<br>";
            echo "<h4>📋 Script SQL para crear la tabla productos:</h4>";
            echo "<pre style='background:#f8f9fa; padding:15px; border-radius:5px;'>";
            echo "CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    categoria VARCHAR(100),
    estado_reserva ENUM('disponible', 'reservado') DEFAULT 'disponible',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);";
            echo "</pre>";
        } else {
            echo "✅ Tablas encontradas: " . implode(', ', $tables) . "<br>";
            
            if (in_array('productos', $tables)) {
                echo "✅ Tabla 'productos' encontrada<br>";
                
                // Verificar estructura de la tabla
                $stmt = $pdo_full->query("DESCRIBE productos");
                $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo "📋 Estructura de la tabla productos:<br>";
                echo "<table border='1' style='border-collapse:collapse; margin:10px 0;'>";
                echo "<tr><th>Campo</th><th>Tipo</th><th>Null</th><th>Key</th><th>Default</th></tr>";
                foreach ($columns as $column) {
                    echo "<tr>";
                    echo "<td>" . $column['Field'] . "</td>";
                    echo "<td>" . $column['Type'] . "</td>";
                    echo "<td>" . $column['Null'] . "</td>";
                    echo "<td>" . $column['Key'] . "</td>";
                    echo "<td>" . $column['Default'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                
                // Contar registros
                $stmt = $pdo_full->query("SELECT COUNT(*) as total FROM productos");
                $count = $stmt->fetch(PDO::FETCH_ASSOC);
                echo "📊 Total de productos: " . $count['total'] . "<br>";
            } else {
                echo "❌ Tabla 'productos' no encontrada<br>";
            }
        }
        
    } else {
        echo "❌ Base de datos '" . Config::DB_NAME . "' no encontrada<br>";
        echo "💡 Puedes crear la base de datos ejecutando: CREATE DATABASE " . Config::DB_NAME . ";<br>";
    }
    
} catch (PDOException $e) {
    echo "❌ Error de conexión: " . $e->getMessage() . "<br>";
    echo "🔍 Código de error: " . $e->getCode() . "<br>";
    
    // Sugerencias basadas en el error
    if (strpos($e->getMessage(), 'Connection refused') !== false) {
        echo "💡 <strong>Sugerencia:</strong> MySQL no está corriendo. Asegúrate de que MAMP esté iniciado.<br>";
    } elseif (strpos($e->getMessage(), 'Access denied') !== false) {
        echo "💡 <strong>Sugerencia:</strong> Credenciales incorrectas. Verifica usuario y contraseña.<br>";
    } elseif (strpos($e->getMessage(), 'Unknown database') !== false) {
        echo "💡 <strong>Sugerencia:</strong> La base de datos no existe. Créala primero.<br>";
    }
}

// 4. Verificar archivos del sistema
echo "<h3>4. Verificación de Archivos del Sistema:</h3>";
$archivos = [
    './index.php' => 'Archivo principal',
    './routes/routes.php' => 'Archivo de rutas',
    './controllers/ProductoController.php' => 'Controlador de productos',
    './config/database.php' => 'Configuración de base de datos',
    './config/config.php' => 'Configuración general'
];

foreach ($archivos as $archivo => $descripcion) {
    if (file_exists($archivo)) {
        echo "✅ $descripcion: $archivo<br>";
    } else {
        echo "❌ $descripcion: $archivo (no encontrado)<br>";
    }
}

// 5. Información del servidor
echo "<h3>5. Información del Servidor:</h3>";
echo "📍 Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "📍 Script Name: " . $_SERVER['SCRIPT_NAME'] . "<br>";
echo "📍 Request URI: " . $_SERVER['REQUEST_URI'] . "<br>";
echo "📍 HTTP Host: " . $_SERVER['HTTP_HOST'] . "<br>";

echo "<h3>6. Próximos Pasos:</h3>";
echo "1. Si MAMP no está iniciado, inicia los servicios Apache y MySQL<br>";
echo "2. Si la base de datos no existe, créala desde phpMyAdmin o línea de comandos<br>";
echo "3. Si la tabla no existe, ejecuta el script SQL mostrado arriba<br>";
echo "4. Luego prueba la API en: <a href='api-test.html'>api-test.html</a><br>";
?>
