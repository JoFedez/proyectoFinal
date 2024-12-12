<?php
// Incluir el autoloader de Composer y el controlador de currículums
require '../vendor/autoload.php';
use App\Controllers\CVController;

$controller = new CVController(); // Instancia del controlador de currículums

// Obtener el correo del usuario desde la URL
$email = isset($_GET['email']) ? $_GET['email'] : '';

// Obtener los currículums del usuario
$curriculums = $controller->getCurriculumsByEmail($email);

echo '
    <div class="container mt-5">
        <h2 class="text-center mb-4">Gestión de Currículums</h2>
        <a href="create_cv.php?email=' . urlencode($email) . '" class="btn btn-success mb-3">Crear Nuevo Currículum</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>';

foreach ($curriculums as $cv) {
    echo '
        <tr>
            <td>' . $cv['id'] . '</td>
            <td>' . $cv['name'] . '</td>
            <td>' . $cv['email'] . '</td>
            <td>' . $cv['phone'] . '</td>
            <td>
                <a href="edit_cv.php?id=' . $cv['id'] . '" class="btn btn-warning btn-sm">Editar</a>
                <a href="delete_cv.php?id=' . $cv['id'] . '" class="btn btn-danger btn-sm">Eliminar</a>
            </td>
        </tr>';
}

echo '
            </tbody>
        </table>
    </div>';
?>