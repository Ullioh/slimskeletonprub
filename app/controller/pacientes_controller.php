<?php

namespace App\Controller;

use App\Config\InitController;
use App\Lib\Validate;
use App\Lib\Response;
use App\Config\ConfigGlobal;
use App\Lib\MailSender;
use App\Model\PacientesModel;


class PacientesController extends InitController
{
    private $validate;
    private $respuesta;
    private $config;
    private $mailSender;
    private $PacientesModel;

    public function __construct(){
        parent::__construct();
        $this->validate = new Validate();
        $this->respuesta = new Response();
        $this->config = new ConfigGlobal();
        $this->mailSender = new MailSender();
        $this->PacientesModel = new PacientesModel ();
    }

    public function AddPaciente($req,$res,$args){
      $var = $req->getParsedBody();
        $this->validate->setRequireExtended($var,array(
            "cedula"   => array(
                "type"     => "is_numeric",
            ),
            "nombre"   => array(
                "type"     => "is_string",
            ),
            "genero"   => array(
                "type"     => "is_string",
            ),
            "edad"   => array(
                "type"     => "is_numeric",
            ),
        )
    );

        if(!$data = $this->validateData($this->validate)){
            return $this->ending($res,$this->validate);
        }

        $add = $this->PacientesModel->insert([
            "cedula" => $data['cedula'],
            "nombre" => $data['nombre'],
            "genero" => $data['genero'],
            "edad"   => $data['edad'],
        ]);

        $this->respuesta->setResponse(true,200,"");
        $this->respuesta->data = $add;
        return $res
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200)
        ->write(
            json_encode(
                $this->respuesta
            )
        );
    }

    public function UpdatePaciente($req,$res,$argsc){
        $var = $req->getParsedBody();
        $this->validate->setRequireExtended($var,array(
            "id"   => array(
                "type"     => "is_numeric",
            ),
            "nombre"   => array(
                "type"     => "is_string",
            ),
            "genero"   => array(
                "type"     => "is_string",
            ),
            "edad"   => array(
                "type"     => "is_numeric",
            ),
        )
    );

        if(!$data = $this->validateData($this->validate)){
            return $this->ending($res,$this->validate);
        }

        $update = $this->PacientesModel->update([
            "id"     => $data['id'],
            "nombre" => $data['nombre'],
            "genero" => $data['genero'],
            "edad"   => $data['edad'],
        ]);

        $this->respuesta->setResponse(true,200,"");
        $this->respuesta->data = $update;
        return $res
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200)
        ->write(
            json_encode(
                $this->respuesta
            )
        );
    }

    public function DeletePaciente($req,$res,$argsc){
        $var = $req->getParsedBody();
        $this->validate->setRequireExtended($var,array(
            "id"   => array(
                "type"     => "is_numeric",
            ),
        )
    );
        if(!$data = $this->validateData($this->validate)){
            return $this->ending($res,$this->validate);
        }

        $delete = $this->PacientesModel->delete($data['id']);

        $this->respuesta->setResponse(true,200,"");
        $this->respuesta->data = $delete;
        return $res
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200)
        ->write(
            json_encode(
                $this->respuesta
            )
        );
    }

    public function GetIdPacientes($req,$res,$argsc){
        $var = $req->getQueryParams();
        $this->validate->setRequireExtended($var,array(
            "id"   => array(
                "type"     => "is_numeric", 
            ),
        )
    );
        if(!$data = $this->validateData($this->validate)){
            return $this->ending($res,$this->validate);
        }

        $query = $this->PacientesModel->getBy(
            ["id" => $data['id'],
        ]);

        $this->respuesta->setResponse(true,200,"");
        $this->respuesta->data = $query;
        return $res
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200)
        ->write(
            json_encode(
                $this->respuesta
            )
        );
    }

    public function PaginationPaciente($req,$res,$argsc){
        $query = $this->PacientesModel->getPagination(
             [
                 "position" => 0,
                 "limit" => 2,
                 "search" => "",
             ]
        );         
        var_dump($query); die;
    }

    /*public function GetAllPacientes($req,$res,$argsc){
        $query = $this->PacientesModel->getAll();

    /*for ($i=0; $i < count($query); $i++) { 
        echo $query[$i]->cedula . "<br>";
    }*/
    //var_dump($query); die;
    //}

}