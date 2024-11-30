<?php
// Conexión a la base de datos
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'enfermeria';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Establecer cabeceras para la descarga del archivo Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=docentes_enfermeria.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Consulta a la base de datos para obtener todos los registros de docentes
$sql = "SELECT nombre, apellido, edad, area, motivo, sintomas, medicamentos, procedimiento FROM docentes";
$result = $conn->query($sql);

// Generar tabla en formato Excel
if ($result->num_rows > 0) {
    // Cabeceras de la tabla (incluyendo los campos de la tabla docentes)
    echo "Nombre\tApellido\tEdad\tÁrea\tMotivo\tSíntomas\tMedicamentos\tProcedimiento\n";
    
    // Filas de datos
    while ($row = $result->fetch_assoc()) {
        echo $row['nombre'] . "\t" . 
             $row['apellido'] . "\t" . 
             $row['edad'] . "\t" . 
             $row['area'] . "\t" . 
             $row['motivo'] . "\t" . 
             $row['sintomas'] . "\t" . 
             $row['medicamentos'] . "\t" . 
             $row['procedimiento'] . "\n";
    }
} else {
    // Si no hay registros
    echo "No hay registros disponibles para exportar.";
}

$conn->close();
?>
