<?php
use App\Controller\RutaController;
use App\Config\Middleware;


$app->group('/ruta/',function(){

    $middleware = Middleware::class.":onlyUser";;

    // Nueva ruta
    $this->get('new', RutaController::class.":newMethod");

    //ruta post con json y arreglo para representar los json. 
    $this->post('mandar', RutaController::class.":mandar" );
});


?>