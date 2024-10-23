<?php
use App\Controller\BibliotecaController;
use App\Config\Middleware;


$app->group('/biblioteca/',function(){

    $middleware = Middleware::class.":onlyUser";;

    $this->post('add', BibliotecaController::class.":AddBiblioteca");
    $this->post('update', BibliotecaController::class.":UpdateBiblioteca");
    $this->post('delete', BibliotecaController::class.":DeleteBiblioteca");
    $this->get('getby', BibliotecaController::class.":GetIdBiblioteca");
    $this->get('getall', BibliotecaController::class.":PaginationBiblioteca");

});


?>