<?php
namespace App\Config;

use PDO;
use PDOException;

class ConfigGlobal {
    private $dbname = "test_slim";
    private $dbuser = "root";
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

    public function __CONSTRUCT() {
        // Configuración de base de datos
        // También puedes considerar manejar las credenciales de forma más segura
        $this->dbname = "test_slim";
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
        $this->url_base = "http://127.0.0.1/slimSkeleton/";
        $this->server = "http://" . $_SERVER["HTTP_HOST"] . "/slimSkeleton/";
        $this->url_front = "http://localhost:4200/";
    }

    public function getDb() {
        try {
            // Crear la conexión a la base de datos utilizando PDO
            $dsn = "mysql:host=localhost;dbname=" . $this->dbname;
            $pdo = new PDO($dsn, $this->dbuser, $this->dbpassword);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo; // Devuelve la conexión
        } catch (PDOException $e) {
            // Manejo de errores en caso de que la conexión falle
            echo "Error de conexión: " . $e->getMessage();
            return null;
        }
    }

    public function getTokenkey() {
        return $this->token_key;
    }

    public function getMail() {
        return array(
            "mail_host" => $this->mail_host,
            "mail_port" => $this->mail_port,
            "mail_smtp_secure" => $this->mail_smtp_secure,
            "mail_name" => $this->mail_name,
            "mail_user" => $this->mail_user,
            "mail_password" => $this->mail_password,
        );
    }

    public function getServer() {
        return $this->server;
    }

    public function getUrlBase() {
        return $this->url_base;
    }

    public function getUrlFront() {
        return $this->url_front;
    }
}

