<?php

namespace App\Config;

use mysqli;

class Database {

    private $db;

    public function __construct() {
        // Conexión a la base de datos MySQL
        $this->db = new mysqli('localhost', 'root', '', 'cv_db');

        // Verificar la conexión
        if ($this->db->connect_error) {
            die("Conexión fallida: " . $this->db->connect_error);
        }
    }

    public function getDb() {
        return $this->db;
    }
}