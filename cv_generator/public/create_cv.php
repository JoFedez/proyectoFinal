<?php
// Incluir el autoloader de Composer para cargar las clases necesarias
require '../vendor/autoload.php';
use App\Controllers\CVController;

$controller = new CVController(); // Instancia del controlador de currículum

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
    // Datos del formulario
    $data = [
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone'],
        'address' => $_POST['address'],
        'education' => $_POST['education'],
        'experience' => $_POST['experience'],
        'skills' => $_POST['skills']
    ];

    try {
        $controller->create($data); // Crear el currículum
        echo "<div class='alert alert-success mt-3'>Currículum creado exitosamente.</div>";
    } catch (Exception $e) {
        echo "<div class='alert alert-danger mt-3'>Error: " . $e->getMessage() . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Currículum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Crear Nuevo Currículum</h2>
        <form method="POST" action="create_cv.php">
            <input type="hidden" name="action" value="create">
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Correo</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="phone">Teléfono</label>
                <input type="text" name="phone" id="phone" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="address">Dirección</label>
                <input type="text" name="address" id="address" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="education">Educación</label>
                <textarea name="education" id="education" class="form-control" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="experience">Experiencia</label>
                <textarea name="experience" id="experience" class="form-control" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="skills">Habilidades</label>
                <textarea name="skills" id="skills" class="form-control" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-success btn-block">Crear Currículum</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>