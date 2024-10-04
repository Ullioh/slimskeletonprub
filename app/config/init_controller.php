<?php
namespace App\Config;

use App\Lib\Validate;
use App\Lib\Response;

class InitController
{
    protected $respuestaConf;

    public function __construct(){
        $this->respuestaConf = new Response();
    }
    
    protected function validateData($validate){
        if($validate->code!=200){
            return false;
        }else{
            $data=$validate->dataValida;
            return $data;
        }
    }
    
    protected function ending($res,$validate){
        $this->respuestaConf->setResponse(false,$validate->code,$validate->message);
        return $res
        ->withHeader('Content-type','application/json')
        ->withStatus(200)
        ->write(
            json_encode(
                $this->respuestaConf
            )
        );
    }
}