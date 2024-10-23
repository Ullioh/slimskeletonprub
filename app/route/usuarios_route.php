<?php
use App\Controller\UsuariosController;
use App\Config\Middleware;


$app->group('/usuario/',function(){

    $middleware = Middleware::class.":onlyUser";;

    $this->post('register', UsuariosController::class.":Register");
    $this->post('login', UsuariosController::class.":Login");


});


?>