<?php
// Conexión a la base de datos
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'enfermeria';

$conn = new mysqli($host, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Establecer el tipo de contenido a JSON
header('Content-Type: application/json');

// Obtener los parámetros de la URL
$nombre = isset($_GET['nombre']) ? $_GET['nombre'] : '';
$apellido = isset($_GET['apellido']) ? $_GET['apellido'] : '';

// Verificar si el nombre y apellido fueron recibidos
if ($nombre && $apellido) {
    // Consulta para eliminar el registro del docente
    $deleteSql = "DELETE FROM docentes WHERE nombre = ? AND apellido = ?";
    $stmtDelete = $conn->prepare($deleteSql);
    $stmtDelete->bind_param('ss', $nombre, $apellido);

    if ($stmtDelete->execute()) {
        // Responder con un mensaje de éxito
        echo json_encode(["status" => "success", "message" => "El docente fue eliminado correctamente."]);
    } else {
        // Responder con un mensaje de error
        echo json_encode(["status" => "error", "message" => "No se pudo eliminar el docente."]);
    }
} else {
    // Si no se reciben los parámetros, responde con un mensaje de error
    echo json_encode(["status" => "error", "message" => "No se recibieron los datos del docente."]);
}

$conn->close();
?>



