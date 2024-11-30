<?php
// Conexión a la base de datos
$host = 'localhost';
$username = 'root';
$password = '';  // Si tienes una contraseña, ponla aquí
$dbname = 'enfermeria';

// Crear la conexión
$conn = new mysqli($host, $username, $password, $dbname);

// Validar si la conexión fue exitosa
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener el nombre y apellido del docente a editar
if (isset($_GET['nombre']) && isset($_GET['apellido'])) {
    $nombre = $_GET['nombre'];
    $apellido = $_GET['apellido'];

    $sql = "SELECT * FROM docentes WHERE nombre = ? AND apellido = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nombre, $apellido);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nombre_actual = $row['nombre'];
        $apellido_actual = $row['apellido'];
        $edad_actual = $row['edad'];
        $area_actual = $row['area'];
        $motivo_actual = $row['motivo'];
        $sintomas_actual = $row['sintomas'];
        $medicamentos_actual = $row['medicamentos'];
        $procedimiento_actual = $row['procedimiento'];
    } else {
        echo "<script>
                Swal.fire('Error', 'Docente no encontrado.', 'error');
              </script>";
        exit;
    }
} else {
    echo "<script>
            Swal.fire('Error', 'No se ha recibido el nombre y apellido.', 'error');
          </script>";
    exit;
}

// Actualizar la información del docente
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nuevo_nombre = $_POST['nombre'];
    $nuevo_apellido = $_POST['apellido'];
    $nueva_edad = $_POST['edad'];
    $nueva_area = $_POST['area'];
    $nuevo_motivo = $_POST['motivo'];
    $nuevos_sintomas = $_POST['sintomas'];
    $nuevos_medicamentos = $_POST['medicamentos'];
    $nuevo_procedimiento = $_POST['procedimiento'];

    $update_sql = "UPDATE docentes SET 
                    nombre = ?, apellido = ?, edad = ?, area = ?, motivo = ?, 
                    sintomas = ?, medicamentos = ?, procedimiento = ? 
                WHERE nombre = ? AND apellido = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param(
        "ssisssssss",
        $nuevo_nombre, $nuevo_apellido, $nueva_edad, $nueva_area, $nuevo_motivo,
        $nuevos_sintomas, $nuevos_medicamentos, $nuevo_procedimiento,
        $nombre, $apellido
    );

    if ($update_stmt->execute()) {
        echo "<script>
                Swal.fire({
                    title: 'Éxito',
                    text: 'Docente actualizado correctamente.',
                    icon: 'success'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'Registro.php'; // Redirige a la página deseada
                    }
                });
              </script>";
    } else {
        echo "<script>
                Swal.fire('Error', 'Hubo un problema al actualizar el docente.', 'error');
              </script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Docente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
    <link rel="stylesheet" href="pag2.css">
</head>
<style>
    /* Estilos del pie de página */
    footer {
        background-color: rgba(248, 249, 250, 0.8);
        color: black;
        padding: 20px;
        text-align: center;
        position: sticky;
        width: 100%;
        bottom: 0;
        font-size: 14px;
        box-shadow: 0px -2px 10px rgba(0, 0, 0, 0.1);
        left: 5px;
        top: 565px;
    }

    footer a {
        color: #007bff;
        text-decoration: none;
    }

    footer a:hover {
        text-decoration: underline;
    }

    h2 {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 2.5em;
        font-weight: 600;
        color: #2c3e50;
        text-align: center;
        padding: 15px 0;
        margin-bottom: 30px;
        border-bottom: 3px solid #3498db;
        text-transform: capitalize;
        letter-spacing: 1px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease-in-out;
    }

    h2:hover {
        color: #3498db;
        border-color: #2980b9;
        transform: translateY(-3px);
    }
</style>
<body>
    <div class="container mt-5">
        <h2>Editar Docente</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre_actual); ?>" required>
            </div>
            <div class="mb-3">
                <label for="apellido" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo htmlspecialchars($apellido_actual); ?>" required>
            </div>
            <div class="mb-3">
                <label for="edad" class="form-label">Edad</label>
                <input type="number" class="form-control" id="edad" name="edad" value="<?php echo htmlspecialchars($edad_actual); ?>" required>
            </div>
            <div class="mb-3">
                <label for="area" class="form-label">Área</label>
                <select class="form-control" id="area" name="area" required>
                    <option value="basica" <?php echo ($area_actual == "basica") ? 'selected' : ''; ?>>Básica</option>
                    <option value="secundaria" <?php echo ($area_actual == "secundaria") ? 'selected' : ''; ?>>Secundaria</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="motivo" class="form-label">Motivo por el que fue atendido</label>
                <textarea class="form-control" id="motivo" name="motivo" required><?php echo htmlspecialchars($motivo_actual); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="sintomas" class="form-label">Síntomas</label>
                <textarea class="form-control" id="sintomas" name="sintomas" required><?php echo htmlspecialchars($sintomas_actual); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="medicamentos" class="form-label">Medicamentos</label>
                <textarea class="form-control" id="medicamentos" name="medicamentos" required><?php echo htmlspecialchars($medicamentos_actual); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="procedimiento" class="form-label">Procedimiento</label>
                <textarea class="form-control" id="procedimiento" name="procedimiento" required><?php echo htmlspecialchars($procedimiento_actual); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>

    <footer>
        <p>© 2024 Centro Educativo Politécnico Virgen de la Altagracia | Todos los derechos reservados.</p>
    </footer>
</body>
</html>
