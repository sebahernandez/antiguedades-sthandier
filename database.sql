-- Script SQL para crear la base de datos y tabla de productos
-- Ejecuta este script en phpMyAdmin o línea de comandos de MySQL

-- Crear la base de datos si no existe
CREATE DATABASE IF NOT EXISTS artesanias CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Usar la base de datos
USE artesanias;

-- Crear la tabla productos
CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    categoria VARCHAR(100),
    estado_reserva ENUM('disponible', 'reservado') DEFAULT 'disponible',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar algunos datos de prueba
INSERT INTO productos (nombre, descripcion, precio, categoria, estado_reserva) VALUES
('Jarrón Antiguo', 'Hermoso jarrón de cerámica del siglo XIX con decoraciones florales', 150.00, 'ceramica', 'disponible'),
('Mesa de Roble', 'Mesa de comedor de roble macizo de los años 1920', 450.00, 'muebles', 'disponible'),
('Reloj de Péndulo', 'Reloj de péndulo alemán en perfecto estado de funcionamiento', 280.00, 'relojes', 'reservado'),
('Lámpara Tiffany', 'Lámpara estilo Tiffany con pantalla de vidrio emplomado', 320.00, 'iluminacion', 'disponible'),
('Cofre de Madera', 'Cofre de madera tallada a mano del siglo XVIII', 95.00, 'decoracion', 'disponible');

-- Verificar que los datos se insertaron correctamente
SELECT * FROM productos;
