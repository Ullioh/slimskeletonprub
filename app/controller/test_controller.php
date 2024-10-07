<?php

namespace App\Controller;

// Importación de clases y dependencias necesarias
use App\Config\InitController;  // Clase base de controlador
use App\Lib\Validate;  // Librería para validación de datos
use App\Lib\Response;  // Librería para gestionar respuestas HTTP
use App\Config\ConfigGlobal;  // Configuración global de la aplicación
use App\Lib\MailSender;  // Librería para enviar correos electrónicos
use App\Model\TestModel;  // Modelo para la tabla TestModel en la base de datos
use App\Model\ItemTestModel;  // Modelo para la tabla ItemTestModel en la base de datos

/**
 * Clase controlador que maneja las solicitudes HTTP relacionadas con las operaciones de prueba.
 * Esta clase hereda de InitController.
 */
class TestController extends InitController
{
    // Propiedades privadas para gestionar diversas funcionalidades
    private $validate;  // Objeto para validar entradas
    private $respuesta;  // Objeto para gestionar la respuesta HTTP
    private $config;  // Configuraciones globales de la aplicación
    private $mailSender;  // Objeto para enviar correos electrónicos
    private $testModel;  // Modelo para realizar operaciones en la tabla TestModel
    private $itemTestModel;  // Modelo para realizar operaciones en la tabla ItemTestModel

    /**
     * Constructor de la clase que se ejecuta al instanciar el controlador.
     * Aquí se inicializan las propiedades y se llama al constructor del controlador padre (InitController).
     */
    public function __construct(){
        // Llama al constructor de InitController (padre) para que este también se inicialice.
        parent::__construct();
        
        // Inicialización de las propiedades con sus respectivos objetos.
        $this->validate = new Validate();  // Objeto para validación de datos
        $this->respuesta = new Response();  // Objeto para estructurar las respuestas HTTP
        $this->config = new ConfigGlobal();  // Configuración global
        $this->mailSender = new MailSender();  // Herramienta para enviar correos electrónicos
        $this->testModel = new TestModel();  // Modelo de la tabla TestModel
        $this->itemTestModel = new ItemTestModel();  // Modelo de la tabla ItemTestModel
    }

    /**
     * Método 'test' que responde a solicitudes simples devolviendo un mensaje "Hola".
     * Este método puede ser utilizado para comprobar la disponibilidad de la API.
     */
    public function test($req,$res,$args){
        // Devuelve una respuesta HTTP con código 200 (éxito) y el contenido "Hola" en formato JSON.
        return $res
        ->withHeader('Content-type', 'application/json')  // Establece el tipo de contenido como JSON
        ->withStatus(200)  // Código de estado HTTP 200 (éxito)
        ->write(
            json_encode(  // Convierte el texto "Hola" en formato JSON para devolverlo como respuesta
                "Hola"
            )
        );
    }

    /**
     * Método 'get' que maneja las solicitudes HTTP GET.
     * Realiza validaciones sobre los parámetros recibidos, consultas a la base de datos y responde con datos.
     */
    public function get($req,$res,$args){
        // Obtiene los parámetros de consulta enviados en la solicitud HTTP GET (por ejemplo, parámetros en la URL).
        $var = $req->getQueryParams();
        
        // Configura las reglas de validación para los parámetros.
        // En este caso, se está validando que el parámetro 'id' sea un valor numérico.
        $this->validate->setRequireExtended($var,array(
            "id"   => array(
                "type"     => "is_numeric",  // Regla de validación: el 'id' debe ser numérico
            ),
        ));

        // Si la validación de los parámetros falla, se retorna una respuesta de error.
        // El método validateData se encarga de verificar los datos validados.
        if(!$data = $this->validateData($this->validate)){
            // Si los datos no son válidos, se termina la ejecución del método y se envía una respuesta con error.
            return $this->ending($res,$this->validate);
        }

        /**
         * Si la validación es exitosa:
         * 1. Realiza una consulta a la base de datos usando el modelo ItemTestModel.
         * 2. La consulta realiza un INNER JOIN entre las tablas item_test y test.
         * 3. Se seleccionan los campos 'item' y 'email' donde 'id_test' es igual a 1.
         */
        $all = $this->itemTestModel
                // Realiza la unión entre las tablas 'item_test' y 'test' con una condición
                ->innerJoin(new TestModel(),"test.id = item_test.id_test")
                // Selecciona solo las columnas 'item' y 'email' de los resultados
                ->select(["item","email"])
                // Obtiene todos los registros donde 'id_test' sea igual a 1
                ->getAllBy(["id_test"=>1]);

        // Si la consulta es exitosa, prepara una respuesta HTTP con estado 200 y el resultado de la consulta.
        $this->respuesta->setResponse(true,200,"");  // Establece la respuesta con éxito (true) y código 200
        $this->respuesta->data = $all;  // Asigna los datos obtenidos de la base de datos a la respuesta

        // Devuelve la respuesta con los datos en formato JSON.
        return $res
        ->withHeader('Content-type', 'application/json')  // Establece el tipo de contenido como JSON
        ->withStatus(200)  // Código de estado HTTP 200 (éxito)
        ->write(
            json_encode(  // Convierte la respuesta a formato JSON
                $this->respuesta
            )
        );
    }
}

