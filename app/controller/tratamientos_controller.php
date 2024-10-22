<?php

namespace App\Controller;

use App\Config\InitController;
use App\Lib\Validate;
use App\Lib\Response;
use App\Config\ConfigGlobal;
use App\Lib\MailSender;
use App\Model\TratamientosModel;


class TratamientosController extends InitController
{
    private $validate;
    private $respuesta;
    private $config;
    private $mailSender;
    private $TratamientosModel;

    public function __construct(){
        parent::__construct();
        $this->validate = new Validate();
        $this->respuesta = new Response();
        $this->config = new ConfigGlobal();
        $this->mailSender = new MailSender();
        $this->TratamientosModel = new TratamientosModel ();
    }

    public function Add_tratamiento($req,$res,$args){
      $this->TratamientosModel->insert(
            [
                "nombre" => "aca va el nombre del examen creo que deberia ser unico",
                "descripcion" => "aca va la descripcion del examen, basicamene es un resumen de los otros dato que no queria poner",
            ]
        );
    }

    public function Update_tratamiento($req,$res,$argsc){
        $this->TratamientosModel->update(
            [
                "id" => 2,
                "nombre" => "aca edite el nombre",
                "descripcion" => "aca edite la descripcion",
            ]
        );

    }

    public function Delete_tratamiento($req,$res,$argsc){
            $detele = $this->TratamientosModel->delete(2);
    }

    public function Pagination_tratamiento($req,$res,$argsc){
        $query = $this->TratamientosModel->getPagination(
             [
                 "position" => 0,
                 "limit" => 2,
                 "search" => "",
             ]
        );         
        var_dump($query); die;
    }

    public function GetId_tratamiento($req,$res,$argsc){
        $query = $this->TratamientosModel->get(1);

        var_dump($query); die;
    }

    /*public function GetAll_tratamiento($req,$res,$argsc){
            $query = $this->TratamientosModel->getAll();

        /*for ($i=0; $i < count($query); $i++) { 
            echo $query[$i]->cedula . "<br>";
        }*/
        //var_dump($query); die;
   // } */

}