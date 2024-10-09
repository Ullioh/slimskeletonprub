<?php

namespace App\Controller;

use App\Config\InitController;
use App\Lib\Validate;
use App\Lib\Response;
use App\Config\ConfigGlobal;
use App\Lib\MailSender;
use App\Model\TestModel;
use App\Model\ItemTestModel;

class numeroController extends InitController
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

    public function numero($req, $res, $args){
    // Aquí colocas la lógica que desees    
    return $res
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200)
        ->write(
            json_encode(
                [1 => "one", 2 => "two", 3 => "arbol"]
            )
        );
    } // end of new route


}
