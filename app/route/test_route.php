<?php
// Importa el controlador TestController y el Middleware desde sus respectivos espacios de nombres
use App\Controller\TestController;
use App\Config\Middleware;

// Define un grupo de rutas bajo el prefijo '/test/'
$app->group('/test/', function() {
    // Definición del middleware 'onlyUser' para proteger ciertas rutas
    // El middleware se asegura de que solo usuarios autenticados puedan acceder a la ruta protegida
    $middleware = Middleware::class . ":onlyUser ";

    /**
     * Ruta GET /test
     * Llama al método 'test' de la clase TestController.
     * Esta ruta no tiene middleware asociado, por lo que está disponible sin restricciones.
     * Cuando un cliente haga una solicitud GET a /test, se ejecutará el método 'test' del controlador.
     */
    $this->get('test', TestController::class . ":test");

    /**
     * Ruta POST /test_middleware
     * Llama al método 'test' de la clase TestController.
     * A diferencia de la anterior, esta ruta está protegida por el middleware 'onlyUser',
     * lo que significa que solo los usuarios autorizados pueden acceder a ella.
     * Para acceder, los clientes deben realizar una solicitud POST a /test_middleware.
     */
    $this->post('test_middleware', TestController::class . ":test")->add($middleware);

    /**
     * Ruta GET /get
     * Llama al método 'get' de la clase TestController.
     * No tiene middleware, por lo que cualquier cliente puede hacer una solicitud GET a /get
     * y ejecutará el método 'get' del controlador, que realizará una consulta a la base de datos y devolverá datos.
     */
    $this->get('get', TestController::class . ":get");
});

?>
