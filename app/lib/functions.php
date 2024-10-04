<?php
namespace App\Lib;

class Functions{

    function is_base64_string($string){
        if (!preg_match('/^(?:[data]{4}:(text|image|application)\/[a-z]*)/', $string)){
            return false;
        }else{
            return true;
        }
    }
    
}