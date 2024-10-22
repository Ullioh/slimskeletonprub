<?php
use App\Controller\TratamientosController;
use App\Config\Middleware;


$app->group('/tratamientos/',function(){

    $middleware = Middleware::class.":onlyUser";;

    $this->post('add_tratamiento', TratamientosController::class.":Add_tratamiento");
    $this->post('update_tratamiento', TratamientosController::class.":Update_tratamiento");
    $this->post('delete_tratamiento', TratamientosController::class.":Delete_tratamiento");
    //$this->get('getall_tratamiento', TratamientosController::class.":GetAll_tratamiento");
    $this->get('getid_tratamiento', TratamientosController::class.":GetId_tratamiento");
    $this->get('pagination_tratamiento', TratamientosController::class.":Pagination_tratamiento");

});


?>