<?php
namespace App\Lib;

use App\Config\ConfigGlobal;
use \Firebase\JWT\JWT;

class Authorization{

    private $key = "";
    private $arrayCode = array();

    public function __CONSTRUCT(){
        $config = new ConfigGlobal();
        $this->key = $config->getTokenkey();
    }

    public function encode($array){

        $this->arrayCode=$array;

        $jwt = JWT::encode($this->arrayCode, $this->key);

        return $jwt;

    }

    public function decodesAndAuthorizes($token){
        if(empty($token))
        {
            throw new Exception("Invalid token supplied.");
        }
        try{
            $decode = JWT::decode(
                $token,
                $this->key,
                array('HS256')
            );
            $arrayReturn = array(
                "success" => true,
                "decode_token"    => $decode
            );
        }catch(\Firebase\JWT\SignatureInvalidException $e){
            return $arrayReturn = array(
                "success" => false,
                "decode_token"    => array()
            );
        }
        

        return $arrayReturn;
    }

    public function refresh_token($token){
        $decoded = JWT::decode($token, $this->key, array('HS256'));
        $end = $decoded->end;
        $fecha_now = strtotime(date('Y-m-j H:i:s'));
        $fecha_end = strtotime($end);

        
        if($fecha_now > $fecha_end){

            $arrayReturn = array(
                "success" => false,
            );

            return $arrayReturn;

        }else{

            $fecha_end = strtotime ( '+1 hour' , strtotime ( $end ) ) ;
            $fecha_end = date ( 'Y-m-j H:i:s' , $fecha_end );
    
            $this->arrayCode=$decoded;
    
            $this->arrayCode->end=$fecha_end;
    
            $jwt = JWT::encode($this->arrayCode, $this->key);
            
            $arrayReturn = array(
                "success" => true,
                "new_token" => $jwt,
                "decode_token" => $this->arrayCode
            );

            return $arrayReturn;

        }
    }

}