window.onload = function () {
  //<editor-fold desc="Changeable Configuration Block">

  // Configuración mejorada para manejo de CORS
  window.ui = SwaggerUIBundle({
    url: "http://localhost:8888/antiguedades-backend/swagger/swagger.yaml",
    dom_id: "#swagger-ui",
    deepLinking: true,
    presets: [SwaggerUIBundle.presets.apis, SwaggerUIStandalonePreset],
    plugins: [SwaggerUIBundle.plugins.DownloadUrl],
    layout: "StandaloneLayout",
    // Configuración adicional para CORS
    requestInterceptor: (request) => {
      // Agregar headers necesarios para CORS
      request.headers["Access-Control-Allow-Origin"] = "*";
      request.headers["Content-Type"] = "application/json";
      console.log("Swagger UI Request:", request);
      return request;
    },
    responseInterceptor: (response) => {
      console.log("Swagger UI Response:", response);
      return response;
    },
    // Configuración para manejar errores CORS
    onComplete: () => {
      console.log("Swagger UI cargado correctamente");
    },
    onFailure: (error) => {
      console.error("Error en Swagger UI:", error);
    },
  });

  //</editor-fold>
};
