<?php
// Conexión a la base de datos
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'enfermeria';

$conn = new mysqli($host, $username, $password, $dbname);

// Verificar si hay error en la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener parámetros (nombre y apellido del docente)
$nombre = isset($_GET['nombre']) ? $_GET['nombre'] : '';
$apellido = isset($_GET['apellido']) ? $_GET['apellido'] : '';

// Establecer cabeceras para la descarga del archivo Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename={$nombre}_{$apellido}.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Consulta a la base de datos para obtener los registros de docentes, incluyendo los campos adicionales
$sql = "SELECT nombre, apellido, edad, area, motivo, sintomas, medicamentos, procedimiento FROM docentes WHERE nombre = ? AND apellido = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $nombre, $apellido);
$stmt->execute();
$result = $stmt->get_result();

// Generar tabla en formato Excel
if ($result->num_rows > 0) {
    // Escribir cabecera de la tabla
    echo "Nombre\tApellido\tEdad\tÁrea\tMotivo\tSíntomas\tMedicamentos\tProcedimiento\n";
    
    // Mostrar los datos de los docentes
    while ($row = $result->fetch_assoc()) {
        echo $row['nombre'] . "\t" . $row['apellido'] . "\t" . $row['edad'] . "\t" . $row['area'] . "\t" . 
             $row['motivo'] . "\t" . $row['sintomas'] . "\t" . $row['medicamentos'] . "\t" . $row['procedimiento'] . "\n";
    }
} else {
    echo "No hay registros disponibles para exportar.";
}

$stmt->close();
$conn->close();
?>
