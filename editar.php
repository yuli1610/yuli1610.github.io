<?php
/// Conexión a la base de datos
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

// Obtener el nombre y apellido del estudiante a editar
if (isset($_GET['nombre']) && isset($_GET['apellido'])) {
    $nombre = $_GET['nombre'];
    $apellido = $_GET['apellido'];
    
    $sql = "SELECT * FROM estudiantes_enfermeria WHERE nombre = ? AND apellido = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nombre, $apellido);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nombre_actual = $row['nombre'];
        $apellido_actual = $row['apellido'];
        $edad_actual = $row['edad'];
        $aula_actual = $row['aula'];
        $seccion_actual = $row['seccion'];
        $sexo_actual = $row['sexo'];
        $telefono_madre_actual = $row['telefono_madre'];
        $telefono_padre_actual = $row['telefono_padre'];
        $telefono_tutor_actual = $row['telefono_tutor'];
        $nombre_completo_actual = $row['nombre_completo'];
    } else {
        echo "<script>
                Swal.fire('Error', 'Estudiante no encontrado.', 'error');
              </script>";
        exit;
    }
} else {
    echo "<script>
            Swal.fire('Error', 'No se ha recibido el nombre y apellido.', 'error');
          </script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nuevo_nombre = $_POST['nombre'];
    $nuevo_apellido = $_POST['apellido'];
    $nueva_edad = $_POST['edad'];
    $nueva_aula = $_POST['aula'];
    $nueva_seccion = $_POST['seccion'];
    $nuevo_sexo = $_POST['sexo'];
    $nuevo_telefono_madre = $_POST['telefono_madre'];
    $nuevo_telefono_padre = $_POST['telefono_padre'];
    $nuevo_telefono_tutor = $_POST['telefono_tutor'];
    $nuevo_nombre_completo = $_POST['nombre_completo'];

    $update_sql = "UPDATE estudiantes_enfermeria SET 
                    nombre = ?, apellido = ?, edad = ?, aula = ?, seccion = ?, sexo = ?, 
                    telefono_madre = ?, telefono_padre = ?, telefono_tutor = ?, nombre_completo = ? 
                WHERE nombre = ? AND apellido = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param(
        "ssisssssssss",
        $nuevo_nombre, $nuevo_apellido, $nueva_edad, $nueva_aula, $nueva_seccion, $nuevo_sexo,
        $nuevo_telefono_madre, $nuevo_telefono_padre, $nuevo_telefono_tutor, $nuevo_nombre_completo,
        $nombre, $apellido
    );

    if ($update_stmt->execute()) {
        echo "<script>
                Swal.fire({
                    title: 'Éxito',
                    text: 'Estudiante actualizado correctamente.',
                    icon: 'success'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'Registro.php'; // Redirige a la página deseada
                    }
                });
              </script>";
    } else {
        echo "<script>
                Swal.fire('Error', 'Hubo un problema al actualizar el estudiante.', 'error');
              </script>";header('Location: Registro.php');
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Estudiante</title>
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
        <h2>Editar Estudiante</h2>
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
                <label for="aula" class="form-label">Aula</label>
                <input type="text" class="form-control" id="aula" name="aula" value="<?php echo htmlspecialchars($aula_actual); ?>" required>
            </div>
            <div class="mb-3">
                <label for="seccion" class="form-label">Sección</label>
                <input type="text" class="form-control" id="seccion" name="seccion" value="<?php echo htmlspecialchars($seccion_actual); ?>" required>
            </div>
            <div class="mb-3">
                <label for="sexo" class="form-label">Sexo</label>
                <select class="form-control" id="sexo" name="sexo" required>
                    <option value="masculino" <?php echo ($sexo_actual == "Masculino") ? 'selected' : ''; ?>>Masculino</option>
                    <option value="femenino" <?php echo ($sexo_actual == "Femenino") ? 'selected' : ''; ?>>Femenino</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="telefono_madre" class="form-label">Teléfono Madre</label>
                <input type="text" class="form-control" id="telefono_madre" name="telefono_madre" value="<?php echo htmlspecialchars($telefono_madre_actual); ?>">
            </div>
            <div class="mb-3">
                <label for="telefono_padre" class="form-label">Teléfono Padre</label>
                <input type="text" class="form-control" id="telefono_padre" name="telefono_padre" value="<?php echo htmlspecialchars($telefono_padre_actual); ?>">
            </div>
            <div class="mb-3">
                <label for="telefono_tutor" class="form-label">Teléfono Tutor</label>
                <input type="text" class="form-control" id="telefono_tutor" name="telefono_tutor" value="<?php echo htmlspecialchars($telefono_tutor_actual); ?>">
            </div>
            <div class="mb-3">
                <label for="nombre_completo" class="form-label">Nombre Completo</label>
                <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" value="<?php echo htmlspecialchars($nombre_completo_actual); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>

    <footer>
        <p>© 2024 Centro Educativo Politécnico Virgen de la Altagracia | Todos los derechos reservados.</p>
    </footer>
</body>
</html>
