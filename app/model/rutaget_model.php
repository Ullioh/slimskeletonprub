<?php

namespace App\Model;

use PDO;

class MensajeModel {

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
