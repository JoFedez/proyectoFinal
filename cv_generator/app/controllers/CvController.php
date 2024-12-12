<?php

namespace App\Controllers;

use App\Config\Database; // Importar la clase Database
use App\Models\CvModel;
use TCPDF; // Asegúrate de importar TCPDF

class CvController {

    // Método para crear un nuevo CV
    public function create($data) {
        // Instanciar el modelo de CV
        $cvModel = new CvModel();

        // Llamar al método que inserta los datos en la base de datos
        $result = $cvModel->insert($data);

        // Si la inserción fue exitosa, generar el PDF
        if ($result) {
            $this->generatePDF($data); // Llamar al método para generar el PDF
            echo "CV creado exitosamente y PDF generado!";
        } else {
            echo "Error al crear CV.";
        }
    }

    // Método para generar el PDF
    private function generatePDF($data) {
        // Crear una nueva instancia de TCPDF
        $pdf = new TCPDF();

        // Establecer la información del documento
        $pdf->SetCreator('CV Generator');
        $pdf->SetTitle('Currículum Vitae');
        $pdf->SetAuthor('Generador de CV');

        // Agregar una página
        $pdf->AddPage();

        // Configurar el estilo de la fuente
        $pdf->SetFont('helvetica', '', 12);

        // Escribir los datos del formulario en el PDF
        $pdf->Cell(0, 10, 'Curriculum Vitae', 0, 1, 'C');
        $pdf->Ln(5);

        $pdf->Cell(40, 10, 'Nombre:', 0, 0);
        $pdf->Cell(0, 10, $data['name'], 0, 1);

        $pdf->Cell(40, 10, 'Correo:', 0, 0);
        $pdf->Cell(0, 10, $data['email'], 0, 1);

        $pdf->Cell(40, 10, 'Teléfono:', 0, 0);
        $pdf->Cell(0, 10, $data['phone'], 0, 1);

        $pdf->Cell(40, 10, 'Dirección:', 0, 0);
        $pdf->MultiCell(0, 10, $data['address']);

        $pdf->Cell(40, 10, 'Educación:', 0, 0);
        $pdf->MultiCell(0, 10, $data['education']);

        $pdf->Cell(40, 10, 'Experiencia:', 0, 0);
        $pdf->MultiCell(0, 10, $data['experience']);

        $pdf->Cell(40, 10, 'Habilidades:', 0, 0);
        $pdf->MultiCell(0, 10, $data['skills']);

        // Output the PDF to the browser
        $pdf->Output('cv.pdf', 'I'); // 'I' para mostrar el PDF en el navegador
    }

    // Método para obtener currículums por correo electrónico
    public function getCurriculumsByEmail($email) {
        // Crear una instancia de Database para obtener la conexión
        $database = new Database();
        $conn = $database->getDb(); // Obtener la conexión
    
        // Verificar si la conexión fue exitosa
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
    
        // Verificar si el parámetro $email no está vacío
        if (empty($email)) {
            die("El correo electrónico es obligatorio.");
        }
    
        // Consulta para obtener los currículums por email (cambiar cv por cv_table)
        $sql = "SELECT id, name, email, phone, address, education, experience, skills FROM cv_table WHERE email = ?";
        $stmt = $conn->prepare($sql);
    
        // Verificar si la preparación de la consulta fue exitosa
        if ($stmt === false) {
            die('Error en la preparación de la consulta: ' . $conn->error);
        }
    
        $stmt->bind_param('s', $email); // Vincula el parámetro de la consulta
        $stmt->execute();
    
        $result = $stmt->get_result();
        
        // Verificar si hay resultados
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            echo "No se encontraron resultados.";
            return [];
        }
    }

    // Método para editar un CV
    public function editCV($id, $data) {
        // Crear una instancia de Database para obtener la conexión
        $database = new Database();
        $conn = $database->getDb(); // Obtener la conexión

        $sql = "UPDATE cv SET name = ?, phone = ?, address = ?, education = ?, experience = ?, skills = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);

        $stmt->bind_param('ssssssi', $data['name'], $data['phone'], $data['address'], $data['education'], $data['experience'], $data['skills'], $id);

        $stmt->execute();
    }

    // Método para eliminar un CV
    public function deleteCV($id) {
        // Crear una instancia de Database para obtener la conexión
        $database = new Database();
        $conn = $database->getDb(); // Obtener la conexión

        $sql = "DELETE FROM cv WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
    }
}