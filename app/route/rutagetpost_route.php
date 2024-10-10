<?php
use App\Controller\RutasController; //aca hay que cambiar la ubicacion de la ruta.
use App\Config\Middleware;

$app->group('/rutas/', function() {

	$this->get('onlyget', RutasController::class . ":extraer");
	$this->post('onlypost', RutasController::class.":nviar" );

							});
?>

