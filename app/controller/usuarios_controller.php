<?php

namespace App\Controller;

use App\Config\InitController;
use App\Lib\Validate;
use App\Lib\Authorization;
use App\Lib\Response;
use App\Config\ConfigGlobal;
use App\Lib\MailSender;
use App\Model\UsuariosModel;

class UsuariosController extends InitController{
    private $validate;
    private $respuesta;
    private $config;
    private $mailSender;
    private $UsuariosModel;
    private $Authorization;



    public function __construct(){
        parent::__construct();
        $this->validate = new Validate();
        $this->respuesta = new Response();
        $this->config = new ConfigGlobal();
        $this->mailSender = new MailSender();
        $this->UsuariosModel = new UsuariosModel();
        $this->Authorization = new Authorization(); 
    }
 

    public function Register($req, $res, $args) {
        $var = $req->getParsedBody();
        $this->validate->setRequireExtended($var, array(
            "user"      => array("type" => "is_string"),
            "password"  => array("type" => "is_string"),
        ));
        
        if (!$data = $this->validateData($this->validate)) {
            return $this->ending($res, $this->validate); }

        $options = ['cost' => 12,];
        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT, $options);

        $add = $this->UsuariosModel->insert([
            "user"      => $data['user'],
            "password"  => $hashedPassword]);

        $query = $this->UsuariosModel->getBy([
            "id" => $add ]);

        $this->respuesta->setResponse(true, 200, "");
        $this->respuesta->data = $query;
        return $res
            ->withHeader('Content-type', 'application/json')
            ->withStatus(200)
            ->write(
                json_encode($this->respuesta)
            );
    }

    public function Login($req, $res, $args){
        $var = $req->getParsedBody();
        $this->validate->setRequireExtended($var, array(
            "user"      => array("type" => "is_string"),
            "password"  => array("type" => "is_string"),
        )); 

        if(!$data = $this->validateData($this->validate)){
            return $this->ending($res, $this->validate);
        }

        $query = $this->UsuariosModel
        ->where("users.user = '".$data["user"]."'")
        ->first();

        if($query){
            if (password_verify($data["password"], $query->password)) {
                $this->respuesta->setResponse(true,200,"");

                $sendData = array(
                    "id"    => $query->id,
                    "user"  => $query->user
                );

                $token = $this->Authorization->encode($sendData);

                $sendData['token'] = $token;
            }
                $this->respuesta->setResponse(true, 200, "");
                $this->respuesta->data = $sendData;
                return $res
                    ->withHeader('Content-type', 'application/json')
                    ->withStatus(200)
                    ->write(
                        json_encode($this->respuesta));
        }
    }




}
