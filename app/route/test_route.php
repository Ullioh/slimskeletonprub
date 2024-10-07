<?php
use App\Controller\TestController;
use App\Config\Middleware;


$app->group('/test/',function(){

    $middleware = Middleware::class.":onlyUser";;

    $this->get('test', TestController::class.":test");
    $this->post('test_middleware', TestController::class.":test")->add($middleware);
    $this->get('get', TestController::class.":get");

});


?>