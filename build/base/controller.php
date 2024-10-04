<?php

namespace ReplaceNamespace;

ReplaceUse;

class ReplaceName extends InitController
{
    private $validate;
    private $respuesta;
    private $config;
    private $mailSender;

    public function __construct(){
        parent::__construct();
        $this->validate = new Validate();
        $this->respuesta = new Response();
        $this->config = new ConfigGlobal();
        $this->mailSender = new MailSender();
    }

    public function testGet($req,$res,$args){
        $var = $req->getQueryParams();
        $this->validate->setRequireExtended($var,array(
            "id"   => array(
                "type"     => "is_numeric",
                "required" => false,
                "default"  => 0
            ),
        ));

        if(!$data = $this->validateData($this->validate)){
            return $this->ending($res,$this->validate);
        }

        $this->respuesta->setResponse(true,200,"");
        $this->respuesta->data = [];
        return $res
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200)
        ->write(
            json_encode(
                $this->respuesta
            )
        );
    }

    public function testPost($req,$res,$args){
        $var = $req->getParsedBody();
        $this->validate->setRequireExtended($var,array(
            "id"   => array(
                "type"     => "is_numeric",
                "required" => false,
                "default"  => 0
            ),
        ));

        if(!$data = $this->validateData($this->validate)){
            return $this->ending($res,$this->validate);
        }

        $this->respuesta->setResponse(true,200,"");
        $this->respuesta->data = [];
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
