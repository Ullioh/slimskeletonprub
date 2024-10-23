<?php
use App\Controller\PacientesController;
use App\Config\Middleware;


$app->group('/pacientes/',function(){

    $middleware = Middleware::class.":onlyUser";;

    $this->post('add', PacientesController::class.":AddPaciente");
    $this->post('update', PacientesController::class.":UpdatePaciente");
    $this->post('delete', PacientesController::class.":DeletePaciente");
    //$this->get('getallpacientes', PacientesController::class.":GetAllPacientes");
    $this->get('getby', PacientesController::class.":GetIdPacientes");
    $this->get('getall', PacientesController::class.":PaginationPaciente");

});


?>