<?php

namespace App\Models;

use App\Config\Database;

class UserModel {

    private $db;

    public function __construct() {
        // Obtener la conexión de la base de datos
        $database = new Database();
        $this->db = $database->getDb();
    }

    /**
     * Insertar un nuevo usuario en la base de datos.
     */
    public function insert($data) {
        // Consulta SQL para insertar un usuario
        $query = "INSERT INTO users (name, email, password) 
                  VALUES (?, ?, ?)";

        // Preparar la consulta
        $stmt = $this->db->prepare($query);

        // Enlazar los parámetros
        $stmt->bind_param("sss", 
            $data['name'], 
            $data['email'], 
            $data['password']
        );

        // Ejecutar la consulta
        return $stmt->execute();
    }

    /**
     * Buscar un usuario por correo.
     */
    public function findByEmail($email) {
        // Consulta SQL para obtener el usuario
        $query = "SELECT * FROM users WHERE email = ?";

        // Preparar la consulta
        $stmt = $this->db->prepare($query);

        // Enlazar el parámetro
        $stmt->bind_param("s", $email);

        // Ejecutar y obtener el resultado
        $stmt->execute();
        $result = $stmt->get_result();

        // Devolver el resultado como un arreglo asociativo
        return $result->fetch_assoc();
    }

    /**
     * Verificar si un correo ya está registrado.
     */
    public function exists($email) {
        // Consulta SQL para contar usuarios con el correo proporcionado
        $query = "SELECT COUNT(*) AS count FROM users WHERE email = ?";

        // Preparar la consulta
        $stmt = $this->db->prepare($query);

        // Enlazar el parámetro
        $stmt->bind_param("s", $email);

        // Ejecutar la consulta
        $stmt->execute();
        $result = $stmt->get_result();

        // Obtener el valor del conteo
        $row = $result->fetch_assoc();
        return $row['count'] > 0;
    }
}