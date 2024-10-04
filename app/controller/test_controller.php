<?php

namespace App\Controller;

use App\Config\InitController;
use App\Lib\Validate;
use App\Lib\Response;
use App\Config\ConfigGlobal;
use App\Lib\MailSender;
use App\Model\TestModel;
use App\Model\ItemTestModel;

class TestController extends InitController
{
    /**
     * Propiedades privadas de la clase
     */
    private $validate;
    private $respuesta;
    private $config;
    private $mailSender;
    private $testModel;
    private $itemTestModel;

    /**
     * Constructor de la clase
     */
    public function __construct(){
        /**
         * Llama al constructor de la clase padre InitController
         */
        parent::__construct();
        
        /**
         * Inicializa las propiedades privadas de la clase
         */
        $this->validate = new Validate();
        $this->respuesta = new Response();
        $this->config = new ConfigGlobal();
        $this->mailSender = new MailSender();
        $this->testModel = new TestModel();
        $this->itemTestModel = new ItemTestModel();
    }

    /**
     * Método test
     * 
     * Devuelve una respuesta HTTP con un estado de 200 y un contenido JSON que contiene la cadena "Hola"
     */
    public function test($req,$res,$args){
        return $res
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200)
        ->write(
            json_encode(
                "Hola"
            )
        );
    }

    /**
     * Método get
     * 
     * Maneja peticiones GET
     */
    public function get($req,$res,$args){
        /**
         * Obtiene los parámetros de consulta de la petición
         */
        $var = $req->getQueryParams();
        
        /**
         * Valida los parámetros de consulta utilizando el objeto Validate
         */
        $this->validate->setRequireExtended($var,array(
            "id"   => array(
                "type"     => "is_numeric",
            ),
        ));

        /**
         * Si la validación falla, se devuelve una respuesta de error utilizando el método ending
         */
        if(!$data = $this->validateData($this->validate)){
            return $this->ending($res,$this->validate);
        }

        /**
         * Si la validación es exitosa, se realizan las siguientes acciones:
         * 
         * 1. Se utiliza el objeto ItemTestModel para realizar una consulta INNER JOIN con la tabla TestModel y obtener los campos "item" y "email" donde "id_test" es igual a 1
         */
        $all = $this->itemTestModel
                ->innerJoin(new TestModel(),"test.id = item_test.id_test")
                ->select(["item","email"])
                ->getAllBy(["id_test"=>1]);

        /**
         * 2. Se establece la respuesta HTTP con un estado de 200 y un contenido JSON que contiene los resultados de la consulta
         */
        $this->respuesta->setResponse(true,200,"");
        $this->respuesta->data = $all;
        return $res
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200)
        ->write(
            json_encode(
                $this->respuesta
            )
        );
    }
}
