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
header("Content-Disposition: attachment; filename=estudiantes_enfermeria.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Consulta a la base de datos para obtener todos los registros de estudiantes
$sql = "SELECT nombre, apellido, edad, aula, seccion, sexo, telefono_madre, telefono_padre, telefono_tutor, nombre_completo FROM estudiantes_enfermeria";
$result = $conn->query($sql);

// Generar tabla en formato Excel
if ($result->num_rows > 0) {
    // Cabeceras de la tabla
    echo "Nombre\tApellido\tEdad\tAula\tSección\tSexo\tTeléfono Madre\tTeléfono Padre\tTeléfono Tutor\tNombre Completo\n";
    
    // Filas de datos
    while ($row = $result->fetch_assoc()) {
        echo $row['nombre'] . "\t" . 
             $row['apellido'] . "\t" . 
             $row['edad'] . "\t" . 
             $row['aula'] . "\t" . 
             $row['seccion'] . "\t" . 
             $row['sexo'] . "\t" . 
             $row['telefono_madre'] . "\t" . 
             $row['telefono_padre'] . "\t" . 
             $row['telefono_tutor'] . "\t" . 
             $row['nombre_completo'] . "\n";
    }
} else {
    // Si no hay registros
    echo "No hay registros disponibles para exportar.";
}

$conn->close();
?>
