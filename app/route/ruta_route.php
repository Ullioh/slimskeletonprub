<?php
use App\Controller\RutaController;
use App\Config\Middleware;


$app->group('/ruta/',function(){

    $middleware = Middleware::class.":onlyUser";;

    $this->get('test', RutaController::class.":test");
    $this->post('test_middleware', RutaController::class.":test")->add($middleware);
    $this->get('get', RutaController::class.":get");

    // Nueva ruta
    $this->get('new', RutaController::class.":newMethod");

    //ruta post con json y arreglo para representar los json. 
    $this->post('mandar', RutaController::class.":mandar" );
});


?>