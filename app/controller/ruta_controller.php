<?php

namespace App\Controller;

use App\Config\InitController;
use App\Lib\Validate;
use App\Lib\Response;
use App\Config\ConfigGlobal;
use App\Lib\MailSender;
use App\Model\TestModel;
use App\Model\ItemTestModel;

class RutaController extends InitController
{
    private $validate;
    private $respuesta;
    private $config;
    private $mailSender;
    private $testModel;
    private $itemTestModel;

    public function __construct(){
        parent::__construct();
        $this->validate = new Validate();
        $this->respuesta = new Response();
        $this->config = new ConfigGlobal();
        $this->mailSender = new MailSender();
        $this->testModel = new TestModel();
        $this->itemTestModel = new ItemTestModel();
    }

    //nuevo metdo en el controlador

    public function newMethod($req, $res, $args){
    // Aquí colocas la lógica que desees    
    return $res
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200)
        ->write(
            json_encode(
                "nueva ruta de prueba"
            )
        );
    } // end of new route


    //nueva ruta mandar con body y arreglo
    public function mandar($req,$res,$args){
        $body = $req->getParsedBody();
        return $res
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200)
        ->write(
            json_encode(
                array("mensaje"=>$body["mensaje"]) //mandar mensaje
            )
        );
    } // fin de la ruta de mandar. 

}
