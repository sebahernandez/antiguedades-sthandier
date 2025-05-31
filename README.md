# 🧰 API Backend - Antigüedades Sthandier

Este es el backend desarrollado en PHP para el emprendimiento **Antigüedades Sthandier**, como parte de la Evaluación Sumativa Unidad 3 de Desarrollo Backend.

El sistema permite gestionar productos antiguos mediante una API RESTful con operaciones CRUD y está completamente documentado usando **Swagger (OpenAPI)**.

---

## 📦 Contenido del proyecto

antiguedades-backend/
│
├── controllers/ # Lógica de control de productos
├── models/ # Modelo Producto
├── config/ # Configuración base de datos
├── routes/ # Enrutamiento de la API
├── swagger/ # Documentación Swagger
├── swagger-ui/ # Interfaz Swagger UI (opcional)
├── index.php # Entrada principal de la API
├── README.md # Documentación del proyecto
└── database.sql # Script para crear la base de datos

---

## 🚀 Requisitos

- PHP 7.4 o superior
- Servidor Apache (XAMPP recomendado)
- MySQL
- Navegador moderno

---

## ⚙️ Instalación paso a paso

1. Clona o descarga este repositorio.
2. Coloca el proyecto en tu carpeta `htdocs` si usas XAMPP.
3. Crea una base de datos MySQL llamada `antiguedades`.
4. Ejecuta el archivo `database.sql` incluido para crear la tabla `productos`.
5. Asegúrate de que el archivo `config/database.php` tenga tus credenciales correctas.

---

## 🧪 Probar la API

**URL Base:** `http://localhost:8888/antiguedades-backend/index.php`

⚠️ **Nota importante:** Debido a que mod_rewrite no está habilitado en MAMP por defecto, la API utiliza query parameters en lugar de URLs limpias.

### Endpoints principales:

| Método | Query Parameters                        | URL Completa                                                                                | Acción                      |
| ------ | --------------------------------------- | ------------------------------------------------------------------------------------------- | --------------------------- |
| GET    | `?route=productos`                      | `http://localhost:8888/antiguedades-backend/index.php?route=productos`                      | Obtener todos los productos |
| GET    | `?route=productos&id=1`                 | `http://localhost:8888/antiguedades-backend/index.php?route=productos&id=1`                 | Obtener producto por ID     |
| POST   | `?route=productos`                      | `http://localhost:8888/antiguedades-backend/index.php?route=productos`                      | Crear nuevo producto        |
| PUT    | `?route=productos&id=1`                 | `http://localhost:8888/antiguedades-backend/index.php?route=productos&id=1`                 | Actualizar producto por ID  |
| DELETE | `?route=productos&id=1`                 | `http://localhost:8888/antiguedades-backend/index.php?route=productos&id=1`                 | Eliminar producto por ID    |
| PATCH  | `?route=productos&id=1&action=reservar` | `http://localhost:8888/antiguedades-backend/index.php?route=productos&id=1&action=reservar` | Cambiar estado de reserva   |

### 🛠️ Herramientas de prueba

- **Script de diagnóstico:** `http://localhost:8888/antiguedades-backend/diagnostico.php`
- **Script de verificación:** `http://localhost:8888/antiguedades-backend/test.php`
- **Herramienta de pruebas interactiva:** `http://localhost:8888/antiguedades-backend/api-test-new.html`

### 📝 Ejemplos con curl

```bash
# Obtener todos los productos
curl "http://localhost:8888/antiguedades-backend/index.php?route=productos"

# Obtener producto específico
curl "http://localhost:8888/antiguedades-backend/index.php?route=productos&id=1"

# Crear un nuevo producto
curl -X POST "http://localhost:8888/antiguedades-backend/index.php?route=productos" \
  -H "Content-Type: application/json" \
  -d '{
    "nombre": "Nuevo Producto",
    "descripcion": "Descripción del producto",
    "precio": 125.50,
    "categoria": "test"
  }'

# Actualizar un producto
curl -X PUT "http://localhost:8888/antiguedades-backend/index.php?route=productos&id=1" \
  -H "Content-Type: application/json" \
  -d '{
    "nombre": "Producto Actualizado",
    "descripcion": "Nueva descripción",
    "precio": 200.00,
    "categoria": "ceramica"
  }'

# Eliminar un producto
curl -X DELETE "http://localhost:8888/antiguedades-backend/index.php?route=productos&id=5"
```

---

## ✅ Estado del Proyecto - COMPLETADO

### 🎯 Problemas Resueltos:

- ✅ **Conexión a base de datos** - Puerto MySQL corregido de 8888 a 8889 (estándar MAMP)
- ✅ **Sistema de rutas** - Implementado con query parameters (mod_rewrite no disponible)
- ✅ **Todos los endpoints CRUD** - Verificados y funcionando correctamente
- ✅ **Configuración MAMP** - Totalmente adaptado para entorno local
- ✅ **Herramientas de diagnóstico** - Implementadas y funcionales
- ✅ **Base de datos** - Creada con 5 productos de prueba

### 🚀 Endpoints Verificados (Último test: 30 mayo 2025):

| Método | URL                                     | Estado     | Último Test                 |
| ------ | --------------------------------------- | ---------- | --------------------------- |
| GET    | `?route=productos`                      | ✅ EXITOSO | Retorna 5 productos         |
| GET    | `?route=productos&id=1`                 | ✅ EXITOSO | Retorna producto específico |
| POST   | `?route=productos`                      | ✅ EXITOSO | Crea producto con ID 6      |
| PUT    | `?route=productos&id=1`                 | ✅ EXITOSO | Actualiza correctamente     |
| DELETE | `?route=productos&id=X`                 | ✅ EXITOSO | Elimina producto            |
| PATCH  | `?route=productos&id=1&action=reservar` | ✅ EXITOSO | Cambia estado reserva       |

### 🔧 Archivos Clave Modificados:

- `config/config.php` - Puerto MySQL 8889, configuración MAMP
- `routes/routes.php` - Sistema de query parameters
- `controllers/ProductoController.php` - Validaciones mejoradas
- `.htaccess` → `.htaccess.backup` - Deshabilitado por incompatibilidad
- `diagnostico.php` - Herramienta de diagnóstico del sistema
- `api-test-new.html` - Interfaz de pruebas interactiva

---

## 📄 Documentación Swagger

La API está documentada en el archivo:  
📁 `swagger/swagger.yaml`

### Visualizarla usando Swagger Editor:

1. Ve a: [https://editor.swagger.io](https://editor.swagger.io)
2. Borra el contenido inicial y pega el código del archivo `swagger.yaml`.
3. Visualiza y prueba todos los endpoints directamente desde el navegador.

---

## 🎓 Evaluación

Este proyecto fue desarrollado como parte de la **Evaluación Sumativa Unidad 3** del módulo **Desarrollo Backend**. Cubre los siguientes puntos:

- Implementación completa de operaciones CRUD.
- Adaptación del framework PHP a datos del caso real.
- Documentación completa con Swagger.
- Pruebas desde Swagger UI.
- Optimización básica (rate limit, estructura clara).

---

## 🧑‍🤝‍🧑 Equipo de trabajo

- **Integrantes**:
  - Sebastián Lagos
  - Maria José Reichel

---
