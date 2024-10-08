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

    public function get($req,$res,$args){
        $var = $req->getQueryParams();
        $this->validate->setRequireExtended($var,array(
            "id"   => array(
                "type"     => "is_numeric",
            ),
        ));

        if(!$data = $this->validateData($this->validate)){
            return $this->ending($res,$this->validate);
        }

        $all = $this->itemTestModel
                ->innerJoin(new TestModel(),"test.id = item_test.id_test")
                ->select(["item","email"])
                ->getAllBy(["id_te st"=>1]);

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
