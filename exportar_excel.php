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

// Obtener parámetros
$nombre = isset($_GET['nombre']) ? $_GET['nombre'] : '';
$apellido = isset($_GET['apellido']) ? $_GET['apellido'] : '';

// Establecer cabeceras para la descarga del archivo Excel
header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename={$nombre}_{$apellido}.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Consulta a la base de datos
$sql = "SELECT nombre, apellido, edad, aula, seccion, sexo, telefono_madre, telefono_padre, telefono_tutor, nombre_completo, motivo, sintomas, medicamentos, procedimiento 
        FROM estudiantes_enfermeria 
        WHERE nombre = ? AND apellido = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $nombre, $apellido);
$stmt->execute();
$result = $stmt->get_result();

// Generar tabla en formato Excel
if ($result->num_rows > 0) {
    // Establecer los encabezados de los datos exportados
    echo "Nombre\tApellido\tEdad\tAula\tSección\tSexo\tTeléfono Madre\tTeléfono Padre\tTeléfono Tutor\tNombre Completo\tMotivo\tSíntomas\tMedicamentos\tProcedimiento\n";
    
    while ($row = $result->fetch_assoc()) {
        // Asegurarse de que los datos sean seguros para exportar, convirtiendo caracteres especiales si es necesario
        echo htmlspecialchars($row['nombre'], ENT_QUOTES, 'UTF-8') . "\t" .
             htmlspecialchars($row['apellido'], ENT_QUOTES, 'UTF-8') . "\t" .
             htmlspecialchars($row['edad'], ENT_QUOTES, 'UTF-8') . "\t" .
             htmlspecialchars($row['aula'], ENT_QUOTES, 'UTF-8') . "\t" .
             htmlspecialchars($row['seccion'], ENT_QUOTES, 'UTF-8') . "\t" .
             htmlspecialchars($row['sexo'], ENT_QUOTES, 'UTF-8') . "\t" .
             htmlspecialchars($row['telefono_madre'], ENT_QUOTES, 'UTF-8') . "\t" .
             htmlspecialchars($row['telefono_padre'], ENT_QUOTES, 'UTF-8') . "\t" .
             htmlspecialchars($row['telefono_tutor'], ENT_QUOTES, 'UTF-8') . "\t" .
             htmlspecialchars($row['nombre_completo'], ENT_QUOTES, 'UTF-8') . "\t" .
             htmlspecialchars($row['motivo'], ENT_QUOTES, 'UTF-8') . "\t" .
             htmlspecialchars($row['sintomas'], ENT_QUOTES, 'UTF-8') . "\t" .
             htmlspecialchars($row['medicamentos'], ENT_QUOTES, 'UTF-8') . "\t" .
             htmlspecialchars($row['procedimiento'], ENT_QUOTES, 'UTF-8') . "\n";
    }
} else {
    echo "No hay registros disponibles para exportar.";
}

$stmt->close();
$conn->close();
?>
