<?php
use App\Controller\TestController;
use App\Config\Middleware;


// Grupo de rutas bajo el prefijo /test/
$app->group('/test/', function() {
    // Definición de middleware para proteger la ruta test_middleware
    $middleware = Middleware::class . ":onlyUser ";

    // Ruta GET /test que llama al método test de la clase TestController
    $this->get('test', TestController::class . ":test");

    // Ruta POST /test_middleware que llama al método test de la clase TestController
    // y utiliza el middleware onlyUser  para proteger la ruta
    $this->post('test_middleware', TestController::class . ":test")->add($middleware);

    // Ruta GET /get que llama al método get de la clase TestController
    $this->get('get', TestController::class . ":get");
});


?>