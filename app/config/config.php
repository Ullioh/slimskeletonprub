<?php
namespace App\Config;

class ConfigGlobal{
    private $dbname = "";
    private $dbuser = "";
    private $dbpassword = "";

    private $token_key = "";

    private $mail_host = "";
    private $mail_port = "";
    private $mail_smtp_secure = "";
    private $mail_name = ""; 
    private $mail_user = "";
    private $mail_password = "";

    private $server = "";
    private $url_base = "";
    private $url_front = "";

    public function __CONSTRUCT(){
        //DB
        $this->dbname = "test_slim2";
        $this->dbuser = "root";
        $this->dbpassword = "";

        //authorization
        $this->token_key = "test_129671832184234_kieru.leo";

        //mail
        $this->mail_host = "mail.test.com";
        $this->mail_port = "587";
        $this->mail_smtp_secure = "tls";
        $this->mail_name = "test company";
        $this->mail_user = "info@test.com";
        $this->mail_password = "";

        //local
        $this->url_base         = "http://127.0.0.1/slimSkeleton/";
        $this->server           = "http://".$_SERVER["HTTP_HOST"]."/slimSkeleton/";
        $this->url_front        = "http://localhost:4200/";

        //************/
        // $this->url_base         = "http://back.url.com/";
        // $this->server           = "http://".$_SERVER["HTTP_HOST"]."/";
        // $this->url_front        = "http://front.url.com/";
    }

    public function getDb(){
        return array(
            "dbname"        =>  $this->dbname,
            "dbuser"        =>  $this->dbuser,
            "dbpassword"    =>  $this->dbpassword,
        );
    }


                // inicio de la tabla, getDB (voy a cambiar el nombre)

    public function getPostDb() {
        try {
            // Crear la conexión a la base de datos utilizando PDO
            $dsn = "mysql:host=localhost;dbname=" . $this->dbname;
            $pdo = new \PDO($dsn, $this->dbuser, $this->dbpassword); // Añadir la barra invertida aquí
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $pdo; // Devuelve la conexión
        } catch (\PDOException $e) {
            // Manejo de errores en caso de que la conexión falle
            echo "Error de conexión: " . $e->getMessage();
            return null;
        }
    }

    public function getTokenkey(){
        return $this->token_key;
    }

    public function getMail(){
        return array(
            "mail_host" =>  $this->mail_host,
            "mail_port" =>  $this->mail_port,
            "mail_smtp_secure"  =>  $this->mail_smtp_secure,
            "mail_name" =>  $this->mail_name,
            "mail_user" =>  $this->mail_user,
            "mail_password" =>  $this->mail_password,
        );
    }

    public function getServer(){
        return $this->server;
    }

    public function getUrlBase(){
        return $this->url_base;
    }

    public function getUrlFront(){
        return $this->url_front;
    }
}
