<?php
// Definición del espacio de nombres para evitar conflictos con otras clases en el proyecto
namespace App\Config;

/**
 * Clase ConfigGlobal
 * Contiene configuraciones globales de la aplicación, como los parámetros de la base de datos, configuración de correos y URLs.
 */
class ConfigGlobal {
    // Propiedades privadas para la configuración de la base de datos
    private $dbname = "";         // Nombre de la base de datos
    private $dbuser = "";         // Usuario de la base de datos
    private $dbpassword = "";     // Contraseña de la base de datos

    // Propiedad privada para la clave de token
    private $token_key = "";      // Clave secreta utilizada para la generación de tokens de autorización

    // Propiedades privadas para la configuración de correos electrónicos
    private $mail_host = "";      // Servidor SMTP para el envío de correos
    private $mail_port = "";      // Puerto del servidor SMTP
    private $mail_smtp_secure = "";// Método de seguridad para SMTP (TLS/SSL)
    private $mail_name = "";      // Nombre del remitente de los correos
    private $mail_user = "";      // Usuario (correo electrónico) para la autenticación SMTP
    private $mail_password = "";  // Contraseña para la autenticación SMTP

    // Propiedades privadas para la configuración de URLs
    private $server = "";         // URL del servidor
    private $url_base = "";       // URL base de la aplicación backend
    private $url_front = "";      // URL base de la aplicación frontend

    /**
     * Constructor de la clase ConfigGlobal.
     * Inicializa las configuraciones globales para la base de datos, tokens, correos electrónicos, y URLs.
     */
    public function __CONSTRUCT() {
        // Configuración de la base de datos
        $this->dbname = "test_slim";         // Asigna el nombre de la base de datos
        $this->dbuser = "root";              // Asigna el usuario de la base de datos
        $this->dbpassword = "";              // Asigna la contraseña del usuario

        // Configuración del token de autorización
        $this->token_key = "test_129671832184234_kieru.leo"; // Asigna la clave secreta para la generación de tokens

        // Configuración de correos electrónicos
        $this->mail_host = "mail.test.com";  // Asigna el servidor de correo (SMTP)
        $this->mail_port = "587";            // Asigna el puerto SMTP (587 es común para TLS)
        $this->mail_smtp_secure = "tls";     // Asigna el método de seguridad SMTP (TLS)
        $this->mail_name = "test company";   // Asigna el nombre del remitente de los correos
        $this->mail_user = "info@test.com";  // Asigna el usuario (correo electrónico) para autenticarse en SMTP
        $this->mail_password = "";           // Asigna la contraseña del usuario SMTP

        // Configuración de URLs
        $this->url_base = "http://127.0.0.1/slimSkeleton/";  // Asigna la URL base de la aplicación backend
        $this->server = "http://" . $_SERVER["HTTP_HOST"] . "/slimSkeleton/";  // Asigna la URL del servidor actual
        $this->url_front = "http://localhost:4200/";         // Asigna la URL del frontend (Angular, por ejemplo)

        //************/
        // Ejemplo de otra configuración comentada para entorno de producción
        // $this->url_base = "http://back.url.com/";         // URL base para el backend en producción
        // $this->server = "http://" . $_SERVER["HTTP_HOST"] . "/"; // URL del servidor en producción
        // $this->url_front = "http://front.url.com/";       // URL del frontend en producción
    }

    /**
     * Método getDb
     * Devuelve un arreglo con los detalles de la configuración de la base de datos.
     * @return array Arreglo con el nombre de la base de datos, usuario y contraseña.
     */
    public function getDb() {
        return array(
            "dbname"        =>  $this->dbname,      // Nombre de la base de datos
            "dbuser"        =>  $this->dbuser,      // Usuario de la base de datos
            "dbpassword"    =>  $this->dbpassword,  // Contraseña del usuario
        );
    }

    /**
     * Método getTokenkey
     * Devuelve la clave secreta utilizada para la generación de tokens de autorización.
     * @return string Clave secreta para tokens.
     */
    public function getTokenkey() {
        return $this->token_key;
    }

    /**
     * Método getMail
     * Devuelve un arreglo con los detalles de la configuración de correo.
     * @return array Arreglo con las configuraciones del servidor de correo SMTP.
     */
    public function getMail() {
        return array(
            "mail_host" =>  $this->mail_host,          // Servidor SMTP
            "mail_port" =>  $this->mail_port,          // Puerto SMTP
            "mail_smtp_secure"  =>  $this->mail_smtp_secure,  // Método de seguridad (TLS/SSL)
            "mail_name" =>  $this->mail_name,          // Nombre del remitente
            "mail_user" =>  $this->mail_user,          // Usuario (correo electrónico)
            "mail_password" =>  $this->mail_password,  // Contraseña del usuario
        );
    }

    /**
     * Método getServer
     * Devuelve la URL del servidor donde está alojada la aplicación.
     * @return string URL del servidor.
     */
    public function getServer() {
        return $this->server;
    }

    /**
     * Método getUrlBase
     * Devuelve la URL base del backend de la aplicación.
     * @return string URL base del backend.
     */
    public function getUrlBase() {
        return $this->url_base;
    }

    /**
     * Método getUrlFront
     * Devuelve la URL base del frontend de la aplicación.
     * @return string URL base del frontend.
     */
    public function getUrlFront() {
        return $this->url_front;
    }
}
?>
