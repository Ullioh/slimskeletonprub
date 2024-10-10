<?php

namespace App\Model;

use App\Lib\Database;
use App\Config\ConfigGlobal;
use App\Config\InitModel;
use PDO;

class GetModelPost extends InitModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;  // Inyección de la conexión a la base de datos
    }

    // Método para insertar el mensaje
    public function guardarMensaje($mensaje) {
        $query = $this->db->prepare("INSERT INTO mensajes (mensaje) VALUES (:mensaje)");
        $query->bindParam(':mensaje', $mensaje);
        return $query->execute(); // Devuelve true si la operación es exitosa
    }
}

    class MensajesModel {

        private $pdo;

        public function __construct($pdo) {
            $this->pdo = $pdo;
        }


        public function contarMensajes() {
            $sql = "SELECT COUNT(*) as total FROM mensajes";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        }

         public function obtenerMensajes() {
            $sql = "SELECT * FROM mensajes";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
