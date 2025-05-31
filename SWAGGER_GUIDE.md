# 🎯 Guía de Uso - Swagger UI para API Antigüedades

## 🚀 Acceso a Swagger UI

**URL Principal:** http://localhost:8888/antiguedades-backend/swagger-ui/index.html  
**Portal Completo:** http://localhost:8888/antiguedades-backend/swagger-portal.html

---

## 📋 Instrucciones Paso a Paso

### 1. Acceder a Swagger UI

1. Abre tu navegador web
2. Ve a: `http://localhost:8888/antiguedades-backend/swagger-ui/index.html`
3. Espera a que cargue la documentación de la API

### 2. Probar Endpoint GET (Obtener todos los productos)

1. Localiza el endpoint `GET /` en la lista
2. Haz clic para expandirlo
3. Haz clic en **"Try it out"**
4. En el campo `route`, asegúrate que esté `productos`
5. Haz clic en **"Execute"**
6. Verifica la respuesta en la sección "Response body"

### 3. Probar Endpoint GET por ID (Obtener producto específico)

1. Localiza el endpoint `GET /productos-por-id`
2. Haz clic para expandirlo
3. Haz clic en **"Try it out"**
4. Completa los parámetros:
   - `route`: `productos`
   - `id`: `1`
5. Haz clic en **"Execute"**
6. Verifica que obtienes el producto con ID 1

### 4. Probar Endpoint POST (Crear producto)

1. Localiza el endpoint `POST /`
2. Haz clic para expandirlo
3. Haz clic en **"Try it out"**
4. En el campo `route`, escribe `productos`
5. En el cuerpo de la solicitud (Request body), pega este JSON:

```json
{
  "nombre": "Producto desde Swagger",
  "descripcion": "Este producto fue creado usando Swagger UI",
  "precio": 199.99,
  "categoria": "test"
}
```

6. Haz clic en **"Execute"**
7. Verifica que el producto se creó correctamente (status 201)

### 5. Probar Endpoint PUT (Actualizar producto)

1. Localiza el endpoint `PUT /productos-por-id`
2. Haz clic para expandirlo
3. Haz clic en **"Try it out"**
4. Completa los parámetros:
   - `route`: `productos`
   - `id`: `1` (o el ID del producto que quieres actualizar)
5. En el cuerpo de la solicitud, pega:

```json
{
  "nombre": "Producto Actualizado via Swagger",
  "descripcion": "Descripción actualizada desde Swagger UI",
  "precio": 250.0,
  "categoria": "ceramica",
  "estado_reserva": "disponible"
}
```

6. Haz clic en **"Execute"**

### 6. Probar Endpoint PATCH (Cambiar reserva)

1. Localiza el endpoint `PATCH /productos-reservar`
2. Haz clic para expandirlo
3. Haz clic en **"Try it out"**
4. Completa los parámetros:
   - `route`: `productos`
   - `id`: `1`
   - `action`: `reservar`
5. En el cuerpo de la solicitud:

```json
{
  "estado_reserva": "reservado"
}
```

6. Haz clic en **"Execute"**

### 7. Probar Endpoint DELETE (Eliminar producto)

1. Localiza el endpoint `DELETE /productos-por-id`
2. Haz clic para expandirlo
3. Haz clic en **"Try it out"**
4. Completa los parámetros:
   - `route`: `productos`
   - `id`: `5` (o el ID del producto que quieres eliminar)
5. Haz clic en **"Execute"**
6. ⚠️ **Cuidado:** Este endpoint eliminará permanentemente el producto

---

## 🎯 URLs Completas de Ejemplo

### Para referencia, estas son las URLs completas que Swagger UI utilizará:

1. **GET todos:** `http://localhost:8888/antiguedades-backend/index.php?route=productos`
2. **GET por ID:** `http://localhost:8888/antiguedades-backend/index.php?route=productos&id=1`
3. **POST crear:** `http://localhost:8888/antiguedades-backend/index.php?route=productos`
4. **PUT actualizar:** `http://localhost:8888/antiguedades-backend/index.php?route=productos&id=1`
5. **PATCH reservar:** `http://localhost:8888/antiguedades-backend/index.php?route=productos&id=1&action=reservar`
6. **DELETE eliminar:** `http://localhost:8888/antiguedades-backend/index.php?route=productos&id=5`

---

## ✅ Verificación de Funcionamiento

### Códigos de Respuesta Esperados:

- **200**: Operación exitosa (GET, PUT, PATCH, DELETE)
- **201**: Recurso creado exitosamente (POST)
- **400**: Error en los datos enviados
- **404**: Producto no encontrado
- **500**: Error interno del servidor

### Ejemplos de Respuestas Exitosas:

**GET productos:**

```json
[
  {
    "id": 1,
    "nombre": "Jarrón Antiguo",
    "descripcion": "Hermoso jarrón de cerámica del siglo XIX",
    "precio": "150.00",
    "categoria": "ceramica",
    "estado_reserva": "disponible"
  }
]
```

**POST crear producto:**

```json
{
  "mensaje": "Producto creado exitosamente",
  "id": "9"
}
```

**PUT/PATCH/DELETE:**

```json
{
  "mensaje": "Operación realizada exitosamente"
}
```

---

## 🔧 Solución de Problemas

### Si Swagger UI no carga:

1. Verifica que MAMP esté funcionando: http://localhost:8888
2. Verifica que el archivo swagger.yaml sea accesible: http://localhost:8888/antiguedades-backend/swagger/swagger.yaml

### Si las pruebas fallan:

1. Verifica que la API responde: http://localhost:8888/antiguedades-backend/index.php?route=productos
2. Verifica los headers CORS en las respuestas
3. Revisa la consola del navegador para errores JavaScript

### Si aparecen errores CORS:

- La API ya está configurada con headers CORS apropiados
- Verifica que estás accediendo desde `localhost:8888`

---

## 🎉 ¡Todo Listo!

Swagger UI está completamente configurado y funcionando con la API de Antigüedades Backend. Puedes realizar todas las operaciones CRUD directamente desde la interfaz de Swagger.

**Estado:** ✅ Completamente Funcional  
**Última actualización:** 30 de mayo de 2025
