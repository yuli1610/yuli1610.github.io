<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Datos de conexión a la base de datos
$host = "localhost";
$dbname = "enfermeria";
$username = "root";
$password = "";

// Conexión a la base de datos
$conn = new mysqli($host, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Variables para mensajes de error y campos del formulario
$mensaje_error = '';
$usuario = '';
$contraseña = '';

// Verificar si la sesión está activa
if (isset($_SESSION['usuario'])) {
    // Redirigir solo si no estás en index.php (para depuración)
    if (basename($_SERVER['PHP_SELF']) !== 'index.php') {
        header("Location: RegisEstudiante.php");
        exit;
    }
}

// Manejar el envío del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibe los datos del formulario
    $usuario = trim($_POST['usuario']);
    $contraseña = $_POST['contraseña'];

    // Consulta para buscar el usuario en la base de datos
    $sql = "SELECT * FROM usuarios WHERE usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica si el usuario existe
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Validar contraseña
        if ($contraseña === $user['contraseña']) {
            // Inicia la sesión si las credenciales son correctas
            $_SESSION['usuario'] = $user['usuario'];
            $_SESSION['rol'] = $user['rol'];

            // Redirigir a RegisEstudiante.php
            header("Location: RegisEstudiante.php");
            exit;
        } else {
            $mensaje_error = 'Contraseña incorrecta';
        }
    } else {
        $mensaje_error = 'El usuario no existe';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Inicio de Sesión</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        .eye-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 20px;
            color: #333;
        }
        .input-group {
            position: relative;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sección de bienvenida -->
        <div class="welcome-section">
            <div class="content-wrapper">
                <div class="rocket-image"></div>
                <div class="text-wrapper">
                    <h1><strong>CEPVA</strong></h1>
                    <h2>Centro Educativo Politécnico Virgen de la Altagracia</h2>
                </div>
            </div>
        </div>
        
        <!-- Formulario de inicio de sesión -->
        <div class="login-section">
            <form action="index.php" method="post" onsubmit="return validarFormulario()">
                <h2>INICIAR SESIÓN</h2>

                <div class="input-group">
                    <div class="input-icon">
                        <img src="usuario.png" alt="Ícono Usuario">
                    </div>
                    <input type="text" id="usuario" name="usuario" placeholder="Usuario" value="<?php echo htmlspecialchars($usuario); ?>" required>
                </div>

                <div class="input-group">
                    <div class="input-icon">
                        <img src="contraseña.png" alt="Ícono Contraseña">
                    </div>
                    <input type="password" id="contraseña" name="contraseña" placeholder="Contraseña" required>
                    <span class="material-icons eye-icon" id="togglePassword" onclick="togglePasswordVisibility()">visibility_off</span>
                </div>

                <!-- Mostrar mensaje de error -->
                <?php if ($mensaje_error): ?>
                    <div class="error-message" style="color: red; font-size: 14px; margin-top: 10px;">
                        <p><?php echo $mensaje_error; ?></p>
                    </div>
                <?php endif; ?>

                <button type="submit" class="login-button">Ingresar</button>
            </form>
        </div>
    </div>

    <script>
        // Validación de formulario
        function validarFormulario() {
            var usuario = document.getElementById("usuario").value;
            var contraseña = document.getElementById("contraseña").value;

            if (usuario === "" || contraseña === "") {
                alert("Por favor, ingrese usuario y contraseña.");
                return false;
            }
            return true;
        }

        // Mostrar/ocultar contraseña
        function togglePasswordVisibility() {
            var passwordField = document.getElementById('contraseña');
            var eyeIcon = document.getElementById('togglePassword');
            
            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.textContent = "visibility";
            } else {
                passwordField.type = "password";
                eyeIcon.textContent = "visibility_off";
            }
        }
    </script>
</body>
</html>
