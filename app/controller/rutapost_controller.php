<?php

namespace App\Controller;

use App\Config\InitController;
use App\Lib\Validate;
use App\Lib\Response;
use App\Config\ConfigGlobal;
use App\Lib\MailSender;
use App\Model\TestModelPost;

class RutaPostController extends InitController {
    private $validate;
    private $respuesta;
    private $config;
    private $mailSender;
    private $testModel;

    public function __construct() {
        parent::__construct();
        $this->validate = new Validate();
        $this->respuesta = new Response();
        $this->config = new ConfigGlobal(); // Instanciando ConfigGlobal
        $this->mailSender = new MailSender();

        // Cambiar getDb() a getPostDb()
        $db = $this->config->getPostDb(); // Ahora usa getPostDb()
        $this->testModel = new TestModelPost($db); // Pasando la conexión a TestModelPost
    }

    // nueva ruta mandar con body y arreglo
    public function mandar($req, $res, $args) {
        $body = $req->getParsedBody();
        // Asegurarse de que se recibió el campo "mensaje"
        if (!isset($body['mensaje'])) {
            return $res->withHeader('Content-type', 'application/json')
                ->withStatus(400)
                ->write(json_encode(['error' => 'Mensaje no proporcionado']));
        }

        // Guardar el mensaje en la base de datos
        $mensaje = $body['mensaje'];
        $exito = $this->testModel->guardarMensaje($mensaje); // Utiliza el modelo para insertar el mensaje

        if ($exito) {
            return $res->withHeader('Content-type', 'application/json')
                ->withStatus(200)
                ->write(json_encode(['mensaje' => 'Mensaje guardado con éxito']));
        } else {
            return $res->withHeader('Content-type', 'application/json')
                ->withStatus(500)
                ->write(json_encode(['error' => 'Error al guardar el mensaje']));
        }
    }
}
