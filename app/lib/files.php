<?php
namespace App\Lib;

use PDO;

class Media
{
    private $patch = __DIR__;
    private $patch_back = '/../../app/media/';

    public function upload($uploadedFile,$directorio){
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $filename = $uploadedFile->filename.".".$extension;        
        $uploadedFile->moveTo(realpath($this->patch . $this->patch_back . $directorio) . DIRECTORY_SEPARATOR . $filename);
        return $filename;
    }

    public function delete($file,$directorio){
        if(file_exists(realpath($this->patch . $this->patch_back . $directorio) . DIRECTORY_SEPARATOR . $file)){
            unlink(realpath($this->patch . $this->patch_back . $directorio) . DIRECTORY_SEPARATOR . $file);
            return true;
        }else{
            return false;
        }
    }

    public function typeFile($file){
        $arrayFile=explode(".",$file);
        switch($arrayFile[1]){
            case 'png':{
                return "image";
                break;
            }
            case 'jpg':{
                return "image";
                break;
            }
            case 'jpeg':{
                return "image";
                break;
            }
            case 'gif':{
                return "image";
                break;
            }
            case 'PNG':{
                return "image";
                break;
            }
            case 'JPG':{
                return "image";
                break;
            }
            case 'JPEG':{
                return "image";
                break;
            }
            case 'GIF':{
                return "image";
                break;
            }
            default:{
                return "document";
                break;
            }
        }
    }

    public function qr($data){
        include '../libsext/phpqrcode/qrlib.php';
        QRcode::png($data['datosqr'], $this->patch . $this->patch_back ."qr/".$data['nombrefile'], "L", "4", 2);
    }

    public function getDirectory($directorio){
        return realpath($this->patch . $this->patch_back . $directorio) . DIRECTORY_SEPARATOR;
    }
}