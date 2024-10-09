<?php
use App\Controller\RutaPostController;
use App\Config\Middleware;


$app->group('/rutapost/',function(){

    $middleware = Middleware::class.":onlyUser";;

    //ruta post con json y arreglo para representar los json. 
    $this->post('mandar', RutaPostController::class.":mandar" );
});


?>