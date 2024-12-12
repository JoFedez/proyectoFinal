<?php

namespace App\Controllers;

use App\Models\UserModel;
use Exception;

class UserController {

    /**
     * Manejar el registro de un nuevo usuario.
     */
    public function register($data) {
        $userModel = new UserModel();

        // Validar que el correo no exista ya en la base de datos
        if ($userModel->exists($data['email'])) {
            throw new Exception('El correo ya está registrado.');
        }

        // No cifrar la contraseña, almacenarla directamente
        $data['password'] = $data['password'];

        // Insertar el usuario en la base de datos
        $result = $userModel->insert($data);

        if ($result) {
            echo "Usuario registrado exitosamente!";
        } else {
            throw new Exception('Error al registrar el usuario.');
        }
    }

    /**
     * Manejar el inicio de sesión de usuario.
     */
    public function login($email, $password) {
        $userModel = new UserModel();

        // Obtener el usuario por correo
        $user = $userModel->findByEmail($email);

        // Comparar directamente la contraseña en texto plano
        if ($user && $password === $user['password']) {
            // Guardar los datos del usuario en sesión
            session_start();
            $_SESSION['user'] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email']
            ];
            echo "Inicio de sesión exitoso!";
        } else {
            throw new Exception('Correo o contraseña incorrectos.');
        }
    }

    /**
     * Cerrar la sesión del usuario.
     */
    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        echo "Sesión cerrada exitosamente.";
    }
}