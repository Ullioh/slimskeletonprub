<?php
use App\Controller\ExamenesController;
use App\Config\Middleware;


$app->group('/examenes/',function(){

    $middleware = Middleware::class.":onlyUser";;

    $this->post('add_examen', ExamenesController::class.":Add_Examen");
    $this->post('update_examen', ExamenesController::class.":Update_Examen");
    $this->post('delete_examen', ExamenesController::class.":Delete_Examen");
    //$this->get('getall_examen', ExamenesController::class.":GetAll_Examen");
    $this->get('getid_examen', ExamenesController::class.":GetId_Examen");
    $this->get('pagination_examen', ExamenesController::class.":Pagination_Examen");

});


?>