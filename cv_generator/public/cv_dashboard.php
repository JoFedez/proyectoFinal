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
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Currículums</title>
    <!-- Agregar Bootstrap desde CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .navbar-brand {
            font-weight: bold;
        }
        .footer {
            background-color: #343a40;
            color: #fff;
            padding: 15px;
        }
        .footer p {
            margin-bottom: 0;
        }
    </style>
</head>
<body>

    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">CV Generator</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cv_dashboard.php?email=' . urlencode($email) . '">Mis Currículums</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="container mt-5">
        <h2 class="text-center mb-4">Gestión de Currículums</h2>

        <!-- Botón para crear un nuevo currículum -->
        <div class="mb-4 text-center">
            <a href="create_cv.php?email=' . urlencode($email) . '" class="btn btn-success btn-lg">Crear Nuevo Currículum</a>
        </div>

        <!-- Tabla de currículums -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
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
            <td>' . (isset($cv['phone']) ? $cv['phone'] : 'No disponible') . '</td>
            <td>
                <a href="edit_cv.php?id=' . $cv['id'] . '" class="btn btn-warning btn-sm">
                    <i class="fa fa-pencil"></i> Editar
                </a>
                <a href="delete_cv.php?id=' . $cv['id'] . '" class="btn btn-danger btn-sm">
                    <i class="fa fa-trash"></i> Eliminar
                </a>
            </td>
        </tr>';
}

echo '
            </tbody>
        </table>
    </div>
</div>

<footer class="footer text-center mt-5">
    <p>&copy; 2024 CV Generator. Todos los derechos reservados.</p>
</footer>

<!-- Agregar Bootstrap JS desde CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>'; 
?>
