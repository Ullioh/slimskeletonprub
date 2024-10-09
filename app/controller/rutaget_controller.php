<?php

namespace App\Controller;

use App\Config\InitController;
use App\Lib\Validate;
use App\Lib\Response;
use App\Config\ConfigGlobal;
use App\Lib\MailSender;
use App\Model\TestModel;
use App\Model\ItemTestModel;
use App\Model\MensajeModel; // esta es add nueva


class RutaGetController extends InitController
{
    private $validate;
    private $respuesta;
    private $config; 
    private $mailSender;
    private $testModel;
    private $itemTestModel;
    private $mensajeModel; //esta tambien es nueva


    public function __construct(){
        parent::__construct();
        $this->validate = new Validate();
        $this->respuesta = new Response();
        $this->config = new ConfigGlobal();
        $this->mailSender = new MailSender();
        $this->testModel = new TestModel();
        $this->itemTestModel = new ItemTestModel();
        // Crear la instancia de MensajeModel pasando la conexión PDO
        $pdo = $this->config->getPostDb();
        $this->mensajeModel = new MensajeModel($pdo);
    }

    // Nuevo método para obtener los mensajes
    public function newMethod($req, $res, $args) {
    // Obtener cantidad total de mensajes
    $cantidadMensajes = $this->mensajeModel->contarMensajes();

    // Obtener lista de mensajes
    $listaMensajes = $this->mensajeModel->obtenerMensajes();

    // Preparar la respuesta
    $responseBody = [
        'cantidad' => $cantidadMensajes,
        'mensajes' => $listaMensajes
    ];

    return $res
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200)
        ->write(json_encode($responseBody));
}
}
