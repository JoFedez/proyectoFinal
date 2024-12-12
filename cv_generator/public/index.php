<?php
// Incluir el autoloader de Composer para cargar las clases necesarias
require '../vendor/autoload.php';

// Incluir el controlador de Usuario
use App\Controllers\UserController;

$controller = new UserController(); // Instancia del controlador de usuarios

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'register') {
        // Registro de usuario
        $data = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password' => $_POST['password'], // Guardar la contraseña en texto plano
        ];

        try {
            $controller->register($data); // Método para registrar el usuario
            echo "<div class='alert alert-success mt-3'>Registro exitoso. Ahora puedes iniciar sesión.</div>";

            // Redirigir a la página de gestión de currículums (cv_dashboard.php) pasando el correo del usuario
            header("Location: cv_dashboard.php?email=" . urlencode($data['email']));
            exit;  // Detener la ejecución del script para evitar que se siga procesando después de la redirección
        } catch (Exception $e) {
            echo "<div class='alert alert-danger mt-3'>Error: " . $e->getMessage() . "</div>";
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'login') {
        // Inicio de sesión
        $email = $_POST['email'];
        $password = $_POST['password'];

        try {
            $controller->login($email, $password);
            echo "<div class='alert alert-success mt-3'>Inicio de sesión exitoso. ¡Bienvenido!</div>";

            // Redirigir a la página de gestión de currículums (cv_dashboard.php) pasando el correo del usuario
            header("Location: cv_dashboard.php?email=" . urlencode($email));
            exit;  // Detener la ejecución del script para evitar que se siga procesando después de la redirección
        } catch (Exception $e) {
            echo "<div class='alert alert-danger mt-3'>Error: " . $e->getMessage() . "</div>";
        }
    }
} else {
    // Mostrar los formularios con Bootstrap
    echo '
    <head>
        <!-- Agregar Bootstrap desde CDN -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <h2 class="text-center mb-4">Iniciar sesión</h2>
                    <form method="POST" action="index.php">
                        <input type="hidden" name="action" value="login">
                        <div class="form-group">
                            <label for="email">Correo</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Iniciar sesión</button>
                    </form>

                    <hr>

                    <h2 class="text-center mb-4">Registrarse</h2>
                    <form method="POST" action="index.php">
                        <input type="hidden" name="action" value="register">
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Correo</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success btn-block">Registrarse</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Agregar Bootstrap JS desde CDN -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    </body>';
}
?>