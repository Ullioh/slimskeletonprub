<?php
use App\Controller\PacientesController;
use App\Config\Middleware;


$app->group('/pacientes/',function(){

    $middleware = Middleware::class.":onlyUser";;

    $this->post('addpaciente', PacientesController::class.":AddPaciente");
    $this->post('updatepaciente', PacientesController::class.":UpdatePaciente");
    $this->post('deletepaciente', PacientesController::class.":DeletePaciente");
    //$this->get('getallpacientes', PacientesController::class.":GetAllPacientes");
    $this->get('getidpacientes', PacientesController::class.":GetIdPacientes");
    $this->get('getpaginationpacientes', PacientesController::class.":PaginationPaciente");

});


?>