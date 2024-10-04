<?php
namespace App\Config;

use App\Lib\Validate;
use App\Lib\Response;

class Middleware{

    public function onlyUser($req,$res,$next){
        $validate = new validate();
        $respuesta = new Response();
        $token = $req->getHeader('Authorization');
        $decode=$validate->getAuthorization($token,array("user"));
        if($decode==false){
            $respuesta->setResponse(false,$validate->code,$validate->message);
            return $res
            ->withHeader('Content-type', 'application/json')
            ->withStatus($validate->code)
            ->write(
                json_encode(
                    $respuesta
                )
            );
        }else{
            $req = $req->withAttribute('user', $decode);
            $res = $next($req, $res);
            return $res;
        }
    }
    
}
?>