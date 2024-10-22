<?php

namespace App\Controller;

use App\Config\InitController;
use App\Lib\Validate;
use App\Lib\Response;
use App\Config\ConfigGlobal;
use App\Lib\MailSender;
use App\Model\ExamenesModel;


class ExamenesController extends InitController
{
    private $validate;
    private $respuesta;
    private $config;
    private $mailSender;
    private $ExamenesModel;

    public function __construct(){
        parent::__construct();
        $this->validate = new Validate();
        $this->respuesta = new Response();
        $this->config = new ConfigGlobal();
        $this->mailSender = new MailSender();
        $this->ExamenesModel = new ExamenesModel ();

    }

    public function Add_Examen($req,$res,$args){
      $this->ExamenesModel->insert(
            [
                "nombre" => "aca va el nombre del examen creo que deberia ser unico",
                "descripcion" => "aca va la descripcion del examen, basicamene es un resumen de los otros dato que no queria poner",
            ]

        );
    }

    public function Update_Examen($req,$res,$argsc){
        $this->ExamenesModel->update(
            [
                "id" => 2,
                "nombre" => "aca edite el nombre",
                "descripcion" => "aca edite la descripcion",
            ]

        );

    }

    public function Delete_Examen($req,$res,$argsc){
        $detele = $this->ExamenesModel->delete(2);
    }


    public function GetId_Examen($req,$res,$argsc){
    $query = $this->ExamenesModel->get(1);

    var_dump($query); die;

    }

    public function Pagination_Examen($req,$res,$argsc){
    $query = $this->ExamenesModel->getPagination(
         [
             "position" => 0,
             "limit" => 2,
             "search" => "",
         ]
    );         
    var_dump($query); die;

    }

    /*  public function GetAll_Examen($req,$res,$argsc){
            $query = $this->ExamenesModel->getAll();

        /*for ($i=0; $i < count($query); $i++) { 
            echo $query[$i]->cedula . "<br>";
        }*/
        //var_dump($query); die;
   // } 
        

}