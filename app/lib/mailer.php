<?php
namespace App\Lib;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Config\ConfigGlobal;

class MailSender{
    private $khandus;
    private $host;
    private $port;
    private $smtp_secure;
    private $correo;
    private $clave;
    private $direcciones;
    private $url;
    private $front;

    public function __CONSTRUCT()
    {
        $CONFIG_G = new ConfigGlobal();
        $getMail = $CONFIG_G->getMail();
        $this->host = $getMail['mail_host'];
        $this->port = $getMail['mail_port'];
        $this->smtp_secure = $getMail['mail_smtp_secure'];
        $this->name = $getMail['mail_name'];
        $this->correo = $getMail['mail_user'];
        $this->clave = $getMail['mail_password'];

        $this->url = $CONFIG_G->getServer();
        $this->front = $CONFIG_G->getUrlFront();
    }

    public function sendMail($data){
        
        $mail = new PHPMailer;
        try {
            //Server settings
            if(isset($data['error'])){
                $mail->SMTPDebug = $data['error'];                                 // Enable verbose debug output
            }else{
                $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            }
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = $this->host;  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = $this->correo;                 // SMTP username
            $mail->Password = $this->clave;                           // SMTP password
            // $mail->SMTPSecure = $this->smtp_secure;                            // Enable TLS encryption, `ssl` also accepted
            $mail->SMTPAutoTLS = false; 
            $mail->Port = $this->port;                                    // TCP port to connect to
        
            //Recipients
            $mail->setFrom($this->correo, $this->name);
            $mail->addAddress($data['to_mail'], $data['to_name']);     // Add a recipient
        
            //Content
            switch($data['template']){
                case "test":{
                    $mail->Subject = $this->name.' - test';
                    $mensaje=$this->test($data);
                    break;
                }
            }

            $mail->msgHTML($mensaje);
            $mail->CharSet = 'UTF-8';
            $mail->AltBody = 'Text test';
            $mail->send();
        } catch (Exception $e) {
            echo $mail->ErrorInfo;
        }
    }

    private function test($data){
        return $this->getHeader().'
            <p>texto de prueba</p>
        '.$this->getFooter();
    }

    private function getHeader(){
        return '
        <!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <style type="text/css">
                    
                </style>
            </head>
            <body>
                ';
    }

    private function getFooter(){
        return '
            </body>
        </html>';
    }
}
