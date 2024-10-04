<?php
namespace App\Lib;

use App\Lib\Authorization;
use App\Model\UserModel;

class Validate
{
    public $message;
    public $code;
    public $data;

    public function setRequire($var,$req){
        $data = array();
        foreach($req as $i => $val){
            $options=explode(".",$val);
            if(isset($var[$i])){
                $dato=$var[$i];
                $data[$i]=$this->workVar($options,$i,$dato);
            }else{
                $data[$i]=$this->workVar($options,$i);
            }
        }
        return $data;
    }

    public function getAuthorization($token,$user_type=[]){
        $authorization= new Authorization();

        if(empty($token)){
            $this->message="Token required";
            $this->code=500;
            return false;
        }

        $decode= $authorization->decodesAndAuthorizes($token);

        if ($decode['success']==false){
            $this->message="Invalid Token";
            $this->code=500;
            return false;
        }

        $dataDecode=$decode['decode_token'];

        if(!empty($user_type)){
            $um = new UserModel();
            
            $dataResponse=$um->get($dataDecode->id);
    
            if(empty($dataResponse)){
                $this->message="Non-existent user token";
                $this->code=500;
                return false;
            }
    
            $issue=0;
            foreach($user_type as $clave => $valor){
                if($dataResponse->rol==$valor){
                    $issue=0;
                    break;
                }else{
                    $issue++; 
                }
            }
        }

        if($issue>0){
            $this->message="Invalid user";
            $this->code=500;
            return false;
        }

        return $this->data=$dataResponse;
    }

    private function workVar($options , $ind , $data = null){
        switch($options[0]){
            //numeric
            case 'is_numeric':{
                if(isset($options[1])){
                    switch($options[1]){
                        case 'not-required':{
                            if(!empty($options[2]) && $data==null){
                                $data=$options[2];
                            }else if($data==null){
                                $data=0;
                            }
                            if($data!=null){
                                if(!is_numeric($data)){
                                    $this->message.=$ind." not is numeric \n";
                                    $this->code=400;
                                }
                            }
                            break;
                        }
                        case 'range':{
                            if(!empty($options[2])){
                                if(!is_numeric($data)){
                                    $this->message.=$ind." not is numeric \n";
                                    $this->code=400;
                                }
                                $rango=explode(",",$options[2]);
                                if(count($rango)==2){
                                    if($data<=$rango[0] || $data>=$rango[1]){
                                        $this->message.=$ind." not is in range ".$rango[0]."-".$rango[1]." \n";
                                        $this->code=400;
                                    }
                                }
                            }else{
                                $data=0;
                            }
                            break;
                        }
                        default:{
                            if(!is_numeric($data)){
                                $this->message.=$ind." not is numeric \n";
                                $this->code=400;
                            }
                        }
                    }
                }else{
                    if(!is_numeric($data)){
                        $this->message.=$ind." not is numeric \n";
                        $this->code=400;
                    }
                }
                break;
            }

            //string
            case 'is_string':{
                if(isset($options[1])){
                    switch($options[1]){
                        case 'not-required':{
                            if(!empty($options[2]) && $data==null){
                                $data=$options[2];
                            }else if($data==null){
                                $data="";
                            }
                            if($data!=null){
                                if(!is_string($data)){
                                    $this->message.=$ind." not is string \n";
                                    $this->code=400;
                                }
                            }
                            break;
                        }
                        default:{
                            if(!is_string($data)){
                                $this->message.=$ind." not is string \n";
                                $this->code=400;
                            }
                        }
                    }
                }else{
                    if(!is_string($data)){
                        $this->message.=$ind." not is string \n";
                        $this->code=400;
                    }
                }
                break;
            }

            //float
            case 'is_float':{
                if(isset($options[1])){
                    switch($options[1]){
                        case 'not-required':{
                            if(!empty($options[2]) && $data==null){
                                $data=$options[2];
                            }else if($data==null){
                                $data=0;
                            }
                            if($data!=null){
                                if(!is_numeric($data)){
                                    $this->message.=$ind." not is is_float \n";
                                    $this->code=400;
                                }
                            }
                            break;
                        }
                        case 'range':{
                            if(!empty($options[2])){
                                $rango=explode(",",$options[2]);
                                if(count($rango)==2){
                                    if($data>=$rango[0] && $data<=$rango[1]){
                                        $this->message.=$ind." not is is_float \n";
                                        $this->code=400;
                                    }
                                }
                            }else{
                                $data=0;
                            }
                            break;
                        }
                        default:{
                            if(!is_numeric($data)){
                                $this->message.=$ind." not is is_float \n";
                                $this->code=400;
                            }
                        }
                    }
                }else{
                    if(!is_numeric($data)){
                        $this->message.=$ind." not is is_float \n";
                        $this->code=400;
                    }
                }
                break;
            }
            case 'is_array':{
                if(isset($options[1])){
                    switch($options[1]){
                        case 'not-required':{
                            if(!empty($options[2]) && $data==null){
                                switch($options[2]){
                                    case 'object':{
                                        if(isset($options[3])){
                                            if($data==null){
                                                $data=array();
                                                break;
                                            }
                                            $evalWType=explode(",",$options[3]);
                                            foreach($data as $j => $v){
                                                foreach($evalWType as $k => $ev){
                                                    $eval=explode(":",$ev);
                                                    if(!isset($v[$eval[0]])){
                                                        $this->message.=$eval[0]." is required \n";
                                                        $this->code=400;
                                                    }else{
                                                        switch ($eval[1]){
                                                            case 'is_numeric':{
                                                                if(!is_numeric($v[$eval[0]])){
                                                                    $this->message.=$eval[0]."->".$v[$eval[0]]." not is numeric \n";
                                                                    $this->code=400;
                                                                }
                                                                break;
                                                            }
                                                            case 'is_string':{
                                                                if(!is_string($v[$eval[0]])){
                                                                    $this->message.=$eval[0]."->".$v[$eval[0]]." not is string \n";
                                                                    $this->code=400;
                                                                }
                                                                break;
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }else{
                                            $data=array();
                                        }
                                        break;
                                    }
                                }
                            }
                            break;
                        }
                        case 'object':{
                            if(isset($options[2])){
                                $evalWType=explode(",",$options[2]);
                                foreach($data as $j => $v){
                                    foreach($evalWType as $k => $ev){
                                        $eval=explode(":",$ev);
                                        if(!isset($v[$eval[0]])){
                                            $this->message.=$eval[0]." is required \n";
                                            $this->code=400;
                                        }else{
                                            switch ($eval[1]){
                                                case 'is_numeric':{
                                                    if(!is_numeric($v[$eval[0]])){
                                                        $this->message.=$eval[0]."->".$v[$eval[0]]." not is numeric \n";
                                                        $this->code=400;
                                                    }
                                                    break;
                                                }
                                                case 'is_string':{
                                                    if(!is_string($v[$eval[0]])){
                                                        $this->message.=$eval[0]."->".$v[$eval[0]]." not is string \n";
                                                        $this->code=400;
                                                    }
                                                    break;
                                                }
                                            }
                                        }
                                    }
                                }
                            }else{
                                $this->message.=$ind." not is array type object \n";
                                $this->code=400;
                            }
                            break;
                        }
                        default:{
                            if(!is_array($data)){
                                $this->message.=$ind." not is array \n";
                                $this->code=400;
                            }
                        }
                    }
                }else{
                    if(!is_array($data)){
                        $this->message.=$ind." not is array \n";
                        $this->code=400;
                    }
                }
                break;
            }
            case 'is_date_simple':{
                $valores = explode('-', $data);
                if(!(count($valores) == 3 && checkdate($valores[1], $valores[2], $valores[0]))){
                    $this->message.=$ind." not is date \n";
                    $this->code=400;
                }
                break;
            }
            case 'is_date':{
                $d = DateTime::createFromFormat('Y-m-d H:i:s', $data);
                if(!($d && $d->format($format) == $date)){
                    $this->message.=$ind." not is date \n";
                    $this->code=400;
                }
                break;
            }
        }
        return $data;
    }

    //-----------------------------------------------------------EXTENSION 

    public function setRequireExtended($var,$req){
        foreach($req as $i => $val){
            $validador=$this->trabajar($var,$i,$val);
            if(!$validador['status']){
                $this->message=$validador['mensaje'];
                $this->code=100;
                break;
            }else{
                $this->message="";
                $this->code=200;
                $this->dataValida[$i]=$validador["data"];
            }
        }
        
    }

    private function trabajar($var,$index,$req){
        //requerido
        $retorno["data"]=null;
        $resp_requerido=false;
        if((isset($req['required']) && $req['required']==true) || !isset($req['required'])){
            if(isset($req['required'])){
                $resp_requerido=$this->valueRequiered($index,$var,$req['required']);
            }else{
                $resp_requerido=$this->valueRequiered($index,$var);
            }
            if(!$resp_requerido['status']){
                if(isset($resp_requerido['condition'])){
                    $retorno['status']=false;
                    $retorno['mensaje'] = $index." Error de requisito - Condicionada\n";
                    return $retorno;
                }
                $retorno['mensaje'] = $index." Error de requisito\n";
                $retorno['status']=false;
                return $retorno;
            }
        }

        if(isset($var[$index])){
            $retorno["data"]=$var[$index];
        }

        //valor por defecto
        $resp_default=null;
        if(isset($req['default'])){
            $resp_default=$this->valueDefault($req['default']);
            if(!isset($var[$index])){
                $retorno["data"]=$resp_default;
            }
        }

        //tipo de dato
        if(isset($req['type'])){
            $resp=$this->valueType($req['type'],$resp_requerido,$resp_default,$var,$index);
            if(!$resp){
                $retorno['mensaje'] = $index." no es ".$req['type'];
                $retorno['status']=false;
                return $retorno;
            }
        }

        //rango
        if(isset($req['range']) && isset($var[$index])){
            $resp=$this->valueRange($var,$index,$resp_default,$req['range']);
            if(!$resp['status']){
                $retorno['mensaje'] = $index." fuera del rango; Error ".$resp['mensaje'];
                $retorno['status']=false;
                return $retorno; 
            }
        }

        if(isset($req['model']) && isset($var[$index])){
            if(is_array($req['model'])){
                foreach($var[$index] as $j => $value){
                    if($req['type']=="is_object"){
                        $construyendo_array=array(
                            $j => $value
                        );
                        if(isset($req['model'][$j])){
                            $validador=$this->trabajar($construyendo_array,$j,$req['model'][$j]);
                            if(!$validador['status']){
                                $retorno['mensaje'] = "error\n";
                                $retorno['status']=false;
                                return $retorno;
                            }else{
                                $retorno['mensaje']="";
                                $retorno["data"][]=$validador["data"];
                            }
                        }
                    }else{
                        foreach($req['model'] as $i => $val){
                            $validador=$this->trabajar($value,$i,$val);
                            if(!$validador['status']){
                                $retorno['mensaje'] = "error\n";
                                $retorno['status']=false;
                                return $retorno;
                            }else{
                                $retorno['mensaje']="";
                            }
                        }
                    }
                }
            }else{
                for($i=0; $i<count($var[$index]); $i++){
                    $resp=$this->tipos($req['model'],$var[$index][$i]);
                    if(!$resp){
                        $retorno['mensaje'] = $index." posicion => ".$i." no es ".$req['model'];
                        $retorno['status']=false;
                        return $retorno;
                    }
                }
            }
        }

        $retorno['status']=true;
        return $retorno;
    }

    private function valueRequiered($index,$var,$condicion = array()){
        $retorno=array("status"=>false);
        if(isset($var[$index])){
            if(is_array($condicion)){
                for($i=0; $i<count($condicion);$i++){
                    if(!isset($var[$condicion[$i]])){
                        $retorno['condition']=true;
                        $retorno['status']=false;
                        return $retorno;
                        break;
                    }
                }
            }
            $retorno['status']=true;
            return $retorno;
        }else if(count($condicion)>0){
            for($i=0; $i<count($condicion);$i++){
                if(isset($var[$condicion[$i]])){
                    $retorno['condition']=true;
                    $retorno['status']=false;
                    return $retorno;
                    break;
                }
            }
            $retorno['press']=false;
            $retorno['status']=true;
            return $retorno;
        }
        $retorno['status']=false;
        return $retorno;
    }

    private function valueType($tipo,$requisito,$defecto,$var,$index){
        if(isset($var[$index])){
            return $this->tipos($tipo,$var[$index]);
        }else if(!$requisito['status'] && !isset($var[$index])){
            if($defecto!=null){
                return $this->tipos($tipo,$defecto);
            }else{
                return true;
            }
        }else{
            if(!$requisito['press']){
                return true;
            }
            return false;
        }
    }

    private function valueDefault($val){
        return $val;
    }

    private function tipos($tipo,$val){
        switch($tipo){
            case 'is_numeric':{
                if(is_numeric($val)){
                    $val=intval($val);
                    if(!is_int($val)){
                        return false;
                    }else{
                        return true;
                    }
                }else{
                    return false;
                }
                break;
            }

            //string
            case 'is_string':{
                if(!is_string($val)){
                    return false;
                }else{
                    return true;
                }
                break;
            }

            //float
            case 'is_float':{
                if(!is_numeric($val)){
                    return false;
                }else{
                    return true;
                }
                break;
            }

            //array
            case 'is_array':{
                if(!is_array($val)){
                    return false;
                }else{
                    return true;
                }
                break;
            }

            //array
            case 'is_object':{
                if(!is_array($val)){
                    return false;
                }else{
                    return true;
                }
                break;
            }

            //hora
            case 'is_time':{
                $pattern="/^([0-1][0-9]|[2][0-3])[\:]([0-5][0-9])[\:]([0-5][0-9])$/";
                if(preg_match($pattern,$val))
                    return true;
                return false;
                break;
            }

            //hora
            case 'is_time_no_seconds':{
                $pattern="/^([0-1][0-9]|[2][0-3])[\:]([0-5][0-9])[\:]([0-5][0-9])$/";
                if(preg_match($pattern,$val.":00"))
                {
                    return true;
                }
                return false;
                break;
            }

            //fecha
            case 'is_date_simple':{
                $valores = explode('-', $val);
                if(!(count($valores) == 3 && checkdate($valores[1], $valores[2], $valores[0]))){
                    return false;
                }else{
                    return true;
                }
                break;
            }

            //fecha completa
            case 'is_date':{
                $fecha = date_create_from_format('Y-m-d H:i', $val);
                if(date_format($fecha, 'Y-m-d H:i') == $val){
                    return true;
                }else{
                    return false;
                }
                break;
            }
            //fecha completa local
            case 'is_datetime_local':{
                $fecha_array=explode("T",$val);
                $fecha = $this->tipos("is_date_simple",$fecha_array[0]);
                if(strlen($fecha_array[1])==8){
                    $hora = $this->tipos("is_time",$fecha_array[1]);
                }else if(strlen($fecha_array[1])==5){
                    $hora = $this->tipos("is_time_no_seconds",$fecha_array[1]);
                }
                if($fecha && $hora){
                    return true;
                }else{
                    return false;
                }
                break;
            }
        }
    }

    private function valueRange($var,$index,$defecto,$rango){
        $retorno=array(
            "status"  => false
        );
        if(isset($var[$index])){
            $val=$var[$index];
        }else if($defecto!=null){
            $val=$defecto;
        }else{
            $retorno['status']=false;
            return $retorno;
        }
        foreach($rango as $i => $value){
            switch($i){
                case 'from':{
                    if($this->tipos('is_numeric',$val) || $this->tipos('is_float',$val)){
                        if($val>=$value){
                            $retorno['status'] = true;
                        }else{
                            $retorno['status'] = false;
                            $retorno['mensaje'] = "Valor menor al rango ".$value;                     
                        }
                    }else{
                        $retorno['status'] = false;
                        $retorno['mensaje'] = "No es numerico";    
                    }
                    break;
                }
                case 'to':{
                    if($this->tipos('is_numeric',$val) || $this->tipos('is_float',$val)){
                        if($val<=$value){
                            $retorno['status'] = true;
                        }else{
                            $retorno['status'] = false;  
                            $retorno['mensaje'] = "Valor mayor al rango ".$value;                            
                        }
                    }else{
                        $retorno['status'] = false;
                        $retorno['mensaje'] = "No es numerico ".$value;  
                    }
                    break;
                }
                case 'or':{
                    if(is_array($value)){
                        $retorno['status'] = false;
                        $retorno['mensaje'] = "No cumple con el OR";
                        foreach($value as $j => $valuesArray){
                            if($val==$valuesArray){
                                $retorno['status'] = true;
                                $retorno['mensaje'] = "";
                                break;
                            }
                        }
                    }else{
                        $retorno['status'] = false;
                        $retorno['mensaje'] = "No es un arreglo";  
                    }
                    break;
                }
            }
        }
        if($retorno['status']){
            return $retorno;
        }else{
            return $retorno;
        }
    }
}