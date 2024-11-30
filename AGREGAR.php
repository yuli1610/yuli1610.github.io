<?php 
session_start();

/**
 * Verificar si el usuario tiene sesión activa y es administrador.
 */
function verificarSesionAdmin() {
    if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 'admin') {
        // Si no está logueado o no es admin, redirigir al login
        header("Location: AGREGAR.php");
        exit();
    }
}

/** Lógica principal */

// Verificar sesión y rol
verificarSesionAdmin();

/**
 * Conectar a la base de datos.
 * @return mysqli Conexión activa
 */
function conectarBaseDatos() {
    $host = "localhost";
    $dbname = "enfermeria";
    $username = "root";
    $password = "";

    $conn = new mysqli($host, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    return $conn;
}

/**
 * Procesar datos del formulario y registrar un nuevo usuario en la base de datos.
 * @param mysqli $conn Conexión activa a la base de datos
 * @param array $datos Datos recibidos del formulario
 * @return string Mensaje de resultado
 */
function registrarUsuario($conn, $datos) {
    $usuario = trim($datos['usuario']);
    $contraseña = $datos['contraseña'];
    $rol = $datos['rol'];

    // Validar los datos
    if (empty($usuario) || empty($contraseña) || empty($rol)) {
        return "Todos los campos son obligatorios.";
    }

    // Consulta preparada para insertar usuario
    $sql = "INSERT INTO usuarios (usuario, contraseña, rol) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $usuario, $contraseña, $rol);

    if ($stmt->execute()) {
        $mensaje = "Usuario agregado exitosamente.";
    } else {
        $mensaje = "Error al agregar el usuario: " . $stmt->error;
    }

    $stmt->close(); // Cerrar declaración
    return $mensaje;
}

// Procesar el formulario si se ha enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = conectarBaseDatos();
    $resultado = registrarUsuario($conn, $_POST);
    $conn->close(); // Cerrar conexión

    // Mostrar mensaje de resultado usando SweetAlert
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
        Swal.fire({
            title: '" . ($resultado === 'Usuario agregado exitosamente.' ? 'Éxito' : 'Error') . "',
            text: '$resultado',
            icon: '" . ($resultado === 'Usuario agregado exitosamente.' ? 'success' : 'error') . "',
            confirmButtonText: 'Aceptar'
        });
    </script>";
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Lateral Profesional</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="pag2.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
        }

        /* Ícono del menú */
        .menu-icon {
            position: absolute;
            top: 20px;
            left: 20px;
            cursor: pointer;
            z-index: 3;
        }

        .menu-icon div {
            width: 30px;
            height: 3px;
            background-color: #333;
            margin: 5px 0;
            border-radius: 5px;
            transition: transform 0.4s, background-color 0.4s;
        }

        .menu-icon:hover div {
            background-color: #00bfff;
        }

        /* Estilos del menú lateral */
        .menu-lateral {
            position: fixed;
            top: 0;
            left: -250px;
            width: 250px;
            height: 100%;
            background: #375375;
            color: #fff;
            padding-top: 20px;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.7);
            transition: left 0.5s ease-in-out;
            z-index: 2;
        }
        .menu-visible {
            left: 0;
        }

        .menu-lateral h2 {
            text-align: center;
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .menu-lateral ul {
            list-style: none;
            padding: 0;
        }

        .menu-lateral ul li {
            margin: 15px 0;
        }

        .menu-lateral ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 1.1rem;
            padding: 12px 15px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
            background-color:linear-gradient(180deg, #0a0a0a, #1c1c1c);
            transition: background-color 0.3s, transform 0.3s;
        }

        .menu-lateral ul li a:hover {
            background-color: #00bfff;
            transform: translateX(10px);
        }

        .menu-lateral ul li a i {
            font-size: 1.2rem;
        }

        /* Footer del menú lateral */
        .menu-lateral .footer-menu {
            position: absolute;
            bottom: 20px;
            width: 100%;
            text-align: center;
            font-size: 0.9rem;
            color: #aaa;
        }

        .menu-lateral .footer-menu span {
            font-size: 1.1rem;
            color: #00bfff;
            font-weight: bold;
        }

        /* Estilos del contenido */
        .contenido {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.5s ease-in-out;
        }

        .T1 {
            font-size: 2.5rem;
            text-align: center;
            font-weight: bold;
            color: #333;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
        }

        /* Estilos del pie de página */
        footer {
            background-color: rgba(248, 249, 250, 0.8);;
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

        /* Media Queries para Responsividad */
        @media (max-width: 768px) {
            .menu-lateral {
                width: 200px;
            }
            .contenido {
                margin-left: 0;
            }
        }


        .submenu {
    list-style: none;
    padding-left: 20px;
    margin: 5px 0 0;
}

.submenu li a {
    font-size: 0.9rem;
    padding: 8px 12px;
    display: block;
    background: #2a3d59;
    border-radius: 5px;
}

.submenu li a:hover {
    background-color: #00aaff;
}


.col-md-1{
    position: relative;
    left: 30px;
}

.col-md-2{
    position: relative;
    left: -250px;
}

.col-md-3{
    position: relative;
    left: 30px;
}

.col-md-4{
    position: relative;
    left: -145px;
}

.small-select1 {
    font-size: 12px; /* Tamaño más pequeño del texto */
    padding: 5px 10px; /* Ajusta el espacio interno */
    height: 35px; /* Reduce la altura del selector */
    border: 1px solid #ccc; /* Borde más sutil */
    border-radius: 5px; /* Bordes redondeados */
    background-color: #f9f9f9; /* Fondo claro */
    width: 80%;
}

.small-select1:focus {
    border-color: #007bff; /* Color del borde en foco */
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Sombra suave en foco */
}

label {
    font-size: 12px; /* Ajusta el tamaño del texto del label */
    margin-bottom: 5px; /* Espaciado consistente */
}

.row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px; /* Separación entre filas */
}

.formulario{
    position: relative;
    left: 40px;
}

/* Encabezado */
.header-formulario {
    position: relative;
    left: -45px;
    display: flex;
    align-items: center;
    justify-content: flex-start; /* Ícono y texto alineados al lado */
    gap: 15px; /* Espacio entre el ícono y el texto */
    padding: 10px 15px;
    background-color: #f1f1f1; /* Fondo claro */
    border-radius: 10px; /* Bordes redondeados */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Sombra ligera */
    margin-bottom: 20px;
    width: fit-content; /* Ajustar al contenido */
    margin: auto; /* Centrar horizontalmente */
}

/* Ícono */
.icono-formulario {
    font-size: 40px; /* Tamaño del ícono más grande */
    color: #007bff; /* Azul profesional */
}

/* Título */
.titulo-formulario {
    position: relative;
    font-size: 28px; /* Tamaño de texto más grande */
    font-weight: bold;
    color: #333; /* Color del texto */
    margin: 0;
    left: -10px;

}

.botones .btn {
    font-size: 0.85rem; /* Tamaño más pequeño */
    padding: 8px 15px; /* Menor espaciado interno */
    border-radius: 4px; /* Bordes ligeramente redondeados */
    border: 1px solid transparent; /* Sin borde visible por defecto */
    transition: all 0.3s ease; /* Transición suave */
    cursor: pointer; /* Indicador de clic */
    width: 40%;

}

/* Botón "Agregar" */
btn btn-primary btn-lg1 {
    background-color: #007bff; /* Azul corporativo */
    color: white; /* Texto blanco */
    top: -10px;
}

.btn-agregar:hover {
    background-color: #0056b3; /* Azul más oscuro al pasar el mouse */
}

/* Botón "Cancelar" */
.btn-cancelar {
    background-color: #6c757d; /* Gris oscuro */
    color: white; /* Texto blanco */
}

.btn-cancelar:hover {
    background-color: #495057; /* Gris más oscuro al pasar el mouse */
}

/* Contenedor de los botones alineados horizontalmente */
.botones {
    display: flex;
    gap: 10px; /* Espaciado más pequeño entre botones */
    justify-content: flex-start; /* Alineación a la izquierda */
}


    </style>
</head>
<body>

    <!-- Ícono del menú -->
    <div class="menu-icon" onclick="toggleMenu()">
        <div></div>
        <div></div>
        <div></div>
    </div>

    <!-- Menú Lateral -->
    <div class="menu-lateral" id="menu">
    <h2>Menú</h2>
    <ul>
        <li><a href="usuario.php"><i class="fas fa-house"></i> Inicio</a></li>
        <li>
            <a href="#" onclick="toggleSubMenu(event)">
                <i class="fas fa-user-plus"></i> Agregar <i class="fas fa-caret-down"></i>
            </a>
            <ul class="submenu" style="display: none;">
                <li><a href="RegisDocente.php"><i class="fas fa-chalkboard-teacher"></i> Docente</a></li>
                <li><a href="RegisEstudiante.php"><i class="fas fa-user-graduate"></i> Estudiante</a></li>
            </ul>
        </li>
        <li><a href="#servicios"><i class="fas fa-users"></i> Registro</a></li>
        <li><a href="AGREGAR.php"><i class="fas fa-user-plus"></i> Agregar</a></li>
        <li><a href="TablaDeEnfermeria.php"><i class="fas fa-user-md"></i> Enfermera/o</a></li>
        <li><a href="logout.php"><i class="fas fa-sign-out"></i> Salir</a></li>
        </ul>
    <div class="footer-menu">
        <span class="cepva">CEPVA</span>
    </div>
</div>

        

    <div class="area">

   
<br><br>

<body>

<div class="formulario">
    <div class="header-formulario">
        <i class="fas fa-user-nurse icono-formulario"></i>
        <h2 class="titulo-formulario">Agregar Enfermera/o</h2>
    </div>
    <br><br>

    <form action="AGREGAR.php" method="post">
        <div class="row">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>
        </div>

        <div class="row">
            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" required>
        </div>

        <div class="row">
            <label for="usuario">Usuario:</label>
            <input type="text" id="usuario" name="usuario" required>
        </div>

        <div class="row">
            <label for="contraseña">Contraseña:</label>
            <input type="password" id="contraseña" name="contraseña" required>
        </div>

        <div class="row">
            <label for="rol">Rol:</label>
            <select id="rol" name="rol" class="form-control"required>
                <option value="" disabled selected>Seleccione un rol</option>
                <option value="admin">Administrador</option>
                <option value="enfermero">Usuario</option>
            </select>
        </div>

        <div class="row">
            <label for="area">Tanda:</label>
            <select id="area" name="area" class="form-control" required>
                <option value="" disabled selected>Seleccione la tanda</option>
                <option value="matutina">Matutina</option>
                <option value="vespertina">Vespertina</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary btn-lg1">Agregar</button>
        <button type="reset" class="btn btn-secondary btn-lg2">Cancelar</button>
    </form>
    </form>
</div>
</div>
</div>

    <div class="contenedor">
    <img src="logo2.png" alt="" class="logocepva">
        <h1>Enfermería </h1>
    </div>

    <footer>
        <p>© 2024 Todos los derechos reservados. <a href="#">Terminos de uso</a> | <a href="#">Política de privacidad</a></p>
    </footer>

    <script>
        function toggleMenu() {
            document.getElementById('menu').classList.toggle('menu-visible');
        }

        function toggleSubMenu(event) {
    event.preventDefault();
    const submenu = event.target.nextElementSibling;
    if (submenu) {
        submenu.style.display = submenu.style.display === "none" ? "block" : "none";
    }
}
    </script>
   
</body>
</html>
