<?php
namespace App\Lib;

class Notificaciones
{
    private $usuario = "user";
    private $clave   = "password";

    public function sendText($data){
        switch($data['template']){
			case 'personalizado':{
				$this->sendTextPrivate($data['text'],$data['phone']);
				break;
			}
		}
	}
	
	private function sendTextPrivate($text,$phone){
		if (!empty($phone)){
			$telefonos="58".substr($phone,1);
			$parametros="usuario=".$this->usuario."&clave=".$this->clave."&texto=".$text."&telefonos=".$telefonos;
			$url ="http://sistema.arquisoftsms.net.ve/webservices/SendSms";
			if(strlen($telefonos)==12){
				$handler = curl_init();
				//se coloca la url de envio de sms
				curl_setopt($handler, CURLOPT_URL, $url);
				//se identifica que el envio es por el metodo POST
				curl_setopt($handler, CURLOPT_POST,true);
				//indica que el envio tiene respuesta y no true o false
				curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
				//envio de parametros con metodo post a traves de CURL
				curl_setopt($handler, CURLOPT_POSTFIELDS, $parametros);
				//en la variable respuesta se obtiene el documento xml que genero el envio
				$respuesta = curl_exec ($handler);
				//se cierra el hilo de curl
				curl_close($handler);
				//Ejemplo De Recepción De Data XML Con 
				//se carga el documento xml obtenido por el api
				// $xml = simplexml_load_string($respuesta);
				//con la data suministrada creamos una tabla html como ejemplo
				return $respuesta;
			}else{
                return false;
            }
		}else{
            return false;
        }
	}
}



?>