<?php

namespace App\Models;

use App\Config\Database;

class CvModel {

    private $db;

    public function __construct() {
        // Obtener la conexión de la base de datos
        $database = new Database();
        $this->db = $database->getDb();
    }

    // Método para insertar un nuevo CV en la base de datos
    public function insert($data) {
        // Consulta SQL para insertar los datos
        $query = "INSERT INTO cv_table (name, email, phone, address, education, experience, skills) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";

        // Preparar la consulta
        $stmt = $this->db->prepare($query);

        // Enlazar los parámetros
        $stmt->bind_param("sssssss", 
            $data['name'], 
            $data['email'], 
            $data['phone'], 
            $data['address'], 
            $data['education'], 
            $data['experience'], 
            $data['skills']
        );

        // Ejecutar la consulta
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}