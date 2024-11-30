<<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

// Obtener los parámetros de la URL
$nombre = isset($_GET['nombre']) ? $_GET['nombre'] : '';
$apellido = isset($_GET['apellido']) ? $_GET['apellido'] : '';

// Verificar si el nombre y apellido fueron recibidos
if ($nombre && $apellido) {
    // Consulta para eliminar el registro
    $deleteSql = "DELETE FROM estudiantes_enfermeria WHERE nombre = ? AND apellido = ?";
    $stmtDelete = $conn->prepare($deleteSql);
    $stmtDelete->bind_param('ss', $nombre, $apellido);

    if ($stmtDelete->execute()) {
        // Si la eliminación es exitosa, mostrar una alerta con SweetAlert2
        echo "
        <script>
        Swal.fire({
            title: 'Eliminado',
            text: 'El estudiante fue eliminado correctamente.',
            icon: 'success',
            confirmButtonText: 'Aceptar'
        }).then(() => {
            window.location.href = 'registro.php'; // Redirige a la página de registros
        });
        </script>";
    } else {
        // Si ocurre un error, muestra un mensaje de error
        echo "
        <script>
        Swal.fire({
            title: 'Error',
            text: 'No se pudo eliminar el estudiante: " . $conn->error . "',
            icon: 'error',
            confirmButtonText: 'Aceptar'
        }).then(() => {
            window.location.href = 'registro.php'; // Redirige a la página de registros
        });
        </script>";
    }
} else {
    // Si no se reciben los parámetros, muestra un mensaje de error
    echo "
    <script>
    Swal.fire({
        title: 'Error',
        text: 'No se recibieron los datos del estudiante.',
        icon: 'error',
        confirmButtonText: 'Aceptar'
    }).then(() => {
        window.location.href = 'registro.php'; // Redirige a la página de registros
    });
    </script>";
}

$conn->close();
?>
