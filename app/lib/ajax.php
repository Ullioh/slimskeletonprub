<?php
namespace App\Lib;

class AjaxPhp{
    private $url = "";
    private $method = "";
    private $dataType = "json";
    private $param = array();
    private $header = array();
    private $response;

    public function __CONSTRUCT($data){
        $this->url      = $data['url'];
        $this->method   = $data['method'];
        $this->param    = $data['param'];
        $this->header   = $data['header'];
        if(isset($data['dataType'])){
            $this->dataType = $data['dataType'];
        }
    }

    public function run(){
        $handler = curl_init();
        if($this->method=="post"){
            curl_setopt($handler, CURLOPT_URL, $this->url);
            curl_setopt($handler, CURLOPT_POST,true);
            $params = array();
            foreach ($this->param as $key => $value) {
                $params[] = $key . '=' . urlencode($value);
            }
            curl_setopt($handler, CURLOPT_POSTFIELDS, implode('&', $params));
        }else if($this->method=="get"){
            $params = array();
            foreach ($this->param as $key => $value) {
                $params[] = $key . '=' . urlencode($value);
            }
            curl_setopt($handler, CURLOPT_URL, $this->url."?".implode('&', $params));
            curl_setopt($handler, CURLOPT_HTTPGET,true);
        }
        if(!empty($this->header)){
            curl_setopt($handler, CURLOPT_HTTPHEADER,$this->header);
        }
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        $respuesta = curl_exec ($handler);

        switch($this->dataType){
            case "json":{
                return json_decode($respuesta);
                break;
            }
            case "html":{
                return $respuesta;
                break;
            }
        }
    }
}