<?php

namespace App\Controller;

use App\Config\InitController;
use App\Lib\Validate;
use App\Lib\Response;
use App\Config\ConfigGlobal;
use App\Lib\MailSender;
use App\Model\BibliotecaModel;
use App\Model\PacientesModel;

class BibliotecaController extends InitController
{
    private $validate;
    private $respuesta;
    private $config;
    private $mailSender;
    private $BibliotecaModel;
    private $PacientesModel;

    public function __construct(){
        parent::__construct();
        $this->validate = new Validate();
        $this->respuesta = new Response();
        $this->config = new ConfigGlobal();
        $this->mailSender = new MailSender();
        $this->BibliotecaModel = new BibliotecaModel();
        $this->PacientesModel = new PacientesModel();
    }

    public function AddBiblioteca($req, $res, $args){
        $var = $req->getParsedBody();
        $this->validate->setRequireExtended($var, array(
            "id_paciente"   => array("type" => "is_numeric"),
            "datos"         => array("type" => "is_string"),

        ));
        
        if(!$data = $this->validateData($this->validate)){
            return $this->ending($res, $this->validate);
        }

        $add = $this->BibliotecaModel->insert([
            "id_paciente"   => $data['id_paciente'],
            "datos"         => $data['datos']
        ]);

        $query = $this->BibliotecaModel->getBy([
            "id" => $add
        ]);

        $this->respuesta->setResponse(true, 200, "");
        $this->respuesta->data = $query;
        return $res
            ->withHeader('Content-type', 'application/json')
            ->withStatus(200)
            ->write(
                json_encode($this->respuesta));
    }

    public function UpdateBiblioteca($req, $res, $argsc){
        $var = $req->getParsedBody();
        $this->validate->setRequireExtended($var, array(
            "id"            => array("type" => "is_numeric"),
            "id_paciente"   => array("type" => "is_numeric"),
            "datos"         => array("type" => "is_string"),
        ));
        
        if(!$data = $this->validateData($this->validate)){
            return $this->ending($res, $this->validate);
        }

        $update = $this->BibliotecaModel->update([
            "id"            => $data['id'],
            "id_paciente"   => $data['id_paciente'],
            "datos"         => $data['datos']
        ]);

        $query = $this->BibliotecaModel->getBy([
            "id" => $update
        ]);

        $this->respuesta->setResponse(true, 200, "");
        $this->respuesta->data = $query;
        return $res
            ->withHeader('Content-type', 'application/json')
            ->withStatus(200)
            ->write(json_encode($this->respuesta));
    }

    public function DeleteBiblioteca($req, $res, $argsc){
        $var = $req->getParsedBody();
        $this->validate->setRequireExtended($var, array(
            "id" => array("type" => "is_numeric")
        ));
        
        if(!$data = $this->validateData($this->validate)){
            return $this->ending($res, $this->validate);
        }

        $delete = $this->BibliotecaModel->delete($data['id']);

        $this->respuesta->setResponse(true, 200, "");
        $this->respuesta->data = $delete;
        return $res
            ->withHeader('Content-type', 'application/json')
            ->withStatus(200)
            ->write(json_encode($this->respuesta));
    }

    public function GetIdBiblioteca($req, $res, $argsc){
        $var = $req->getQueryParams();
        $this->validate->setRequireExtended($var, array(
            "id" => array("type" => "is_numeric")
        ));
        
        if(!$data = $this->validateData($this->validate)){
            return $this->ending($res, $this->validate);
        }

        $query = $this->BibliotecaModel
        ->innerJoin(new PacientesModel(),"biblioteca.id_paciente = pacientes.id")
        ->getBy([
            "biblioteca.id" => $data['id']
        ]);

        $this->respuesta->setResponse(true, 200, "");
        $this->respuesta->data = $query;
        return $res
            ->withHeader('Content-type', 'application/json')
            ->withStatus(200)
            ->write(json_encode($this->respuesta));
    }

    public function PaginationBiblioteca($req, $res, $argsc){
        $var = $req->getQueryParams();
        $this->validate->setRequireExtended($var, array(
            "limit"     => array("type" => "is_numeric"),
            "position"  => array("type" => "is_numeric"),
            "search"    => array("type" => "is_string"),  
        ));
        
        if(!$data = $this->validateData($this->validate)){
            return $this->ending($res, $this->validate);
        }

        $query = $this->BibliotecaModel
        ->innerJoin(new PacientesModel(),"biblioteca.id_paciente = pacientes.id")
        ->select(
            ["biblioteca.*", "pacientes.*"]
        )
        ->getPagination($data);
        $this->respuesta->setResponse(true, 200, "");
        $this->respuesta->data = $query;
        return $res
            ->withHeader('Content-type', 'application/json')
            ->withStatus(200)
            ->write(json_encode($this->respuesta));
    }
}
