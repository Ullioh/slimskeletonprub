<?php
use App\Controller\RutaGetController; //aca hay que cambiar la ubicacion de la ruta.
use App\Config\Middleware;


$app->group('/rutaget/',function(){

    $middleware = Middleware::class.":onlyUser";;

    // Nueva ruta - yaca tambien hay que cambiar la ubicacion de la ruta y no se que hace esa funcion. 
    $this->get('newget', RutaGetController::class.":newMethod");

    //ruta post con json y arreglo para representar los json. 
    // $this->post('mandar', RutaController::class.":mandar" );
});


?>