<?php

namespace App\Controller;

use App\Config\InitController;
use App\Lib\Validate;
use App\Lib\Response;
use App\Config\ConfigGlobal;
use App\Lib\MailSender;
use App\Model\RutasModel;
use App\Model\TestModel;
use App\Model\ItemTestModel;
use App\Model\MensajesModel;

/**
 * Controlador de rutas que maneja dos rutas: Extraer y Enviar
 */
class RutasController extends InitController
{
    /**
     * Instancia de Validate para validar datos
     * @var Validate
     */
    private $validate;

    /**
     * Instancia de Response para manejar respuestas
     * @var Response
     */
    private $response;

    /**
     * Instancia de ConfigGlobal para obtener configuración
     * @var ConfigGlobal
     */
    private $config;

    /**
     * Instancia de MailSender para enviar correos electrónicos
     * @var MailSender
     */
    private $mailSender;

    /**
     * Instancia de TestModel para interactuar con la base de datos
     * @var TestModel
     */
    private $testModel;

    /**
     * Instancia de ItemTestModel para interactuar con la base de datos
     * @var ItemTestModel
     */
    private $itemTestModel;

    /**
     * Instancia de RutasModel para interactuar con la base de datos
     * @var RutasModel
     */
    private $rutasModel;

    /**
     * Constructor que inicializa las instancias de los modelos y servicios
     */
    public function __construct()
    {
        parent::__construct();
        $this->validate = new Validate();
        $this->response = new Response();
        $this->config = new ConfigGlobal();
        $this->mailSender = new MailSender();
        $this->testModel = new TestModel();
        $this->itemTestModel = new ItemTestModel();
        $pdo = $this->config->getPostDb();
        $this->rutasModel = new MensajesModel($pdo);

    }

    /**
     * Método que recupera la cantidad total de mensajes y una lista de mensajes
     * @param Request $req
     * @param Response $res
     * @param array $args
     * @return Response
     */
    public function extraer($req, $res, $args)
    {
        // Recuperar la cantidad total de mensajes
        $cantidadMensajes = $this->rutasModel->contarMensajes();

        // Recuperar la lista de mensajes
        $listaMensajes = $this->rutasModel->obtenerMensajes();

        // Preparar el cuerpo de la respuesta
        $responseBody = [
            'cantidad' => $cantidadMensajes,
            'mensajes' => $listaMensajes
        ];

        // Devolver la respuesta en formato JSON con un código de estado 200
        return $res
            ->withHeader('Content-type', 'application/json')
            ->withStatus(200)
            ->write(json_encode($responseBody));
    }

    /**
     * Método que maneja el envío de un mensaje
     * @param Request $req
     * @param Response $res
     * @param array $args
     * @return Response
     */
    public function enviar($req, $res, $args)
    {
        // Recuperar el cuerpo de la solicitud
        $body = $req->getParsedBody();

        // Verificar si el cuerpo de la solicitud contiene un campo "mensaje"
        if (!isset($body['mensaje'])) {
            // Devolver una respuesta de error 400 si el campo "mensaje" no existe
            return $res
                ->withHeader('Content-type', 'application/json')
                ->withStatus(400)
                ->write(json_encode(['error' => 'Mensaje no proporcionado']));
        }

        // Recuperar el mensaje del cuerpo de la solicitud
        $mensaje = $body['mensaje'];

        try {
            // Guardar el mensaje en la base de datos
            $this->testModel->guardarMensaje($mensaje);

            // Devolver una respuesta de éxito con un código de estado 200
            return $res
                ->withHeader('Content-type', 'application/json')
                ->withStatus(200)
                ->write(json_encode(['mensaje' => 'Mensaje guardado con éxito']));
        } catch (\Exception $e) {
            // Devolver una respuesta de error 500 si ocurre un error al guardar el mensaje
            return $res
                ->withHeader('Content-type', 'application/json')
                ->withStatus(500)
                ->write(json_encode(['error' => 'Error al guardar el mensaje: ' . $e->getMessage]));
            }
        }
    }