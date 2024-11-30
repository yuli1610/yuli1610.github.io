<?php
session_start();
include 'conexion_regis.php'; // Conexión a la base de datos

// Variable para verificar si mostrar la alerta
$showAlert = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Recibir datos del formulario
        $usuario = $_POST['usuario'];
        $contraseña = $_POST['contraseña'];
        $rol = $_POST['rol'];

        // Consulta de inserción
        $sql = "INSERT INTO usuarios (usuario, contraseña, rol) VALUES (:usuario, :contraseña, :rol)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':contraseña', $contraseña);
        $stmt->bindParam(':rol', $rol);

        $stmt->execute();

        // Establecer sesión para la alerta
        $_SESSION['showAlert'] = true;

        // Redirigir para evitar reenvío del formulario
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } catch (PDOException $e) {
        // Si ocurre un error, mostrar alerta con el mensaje de error
        $_SESSION['showAlert'] = false; // Error, no mostrar alerta de éxito
        $_SESSION['errorMessage'] = "Error al agregar el usuario: " . $e->getMessage();
        header("Location: " . $_SERVER['PHP_SELF']); // Redirigir para mostrar el mensaje de error
        exit();
    }
}

// Mostrar alerta si la sesión está configurada
if (isset($_SESSION['showAlert']) && $_SESSION['showAlert']) {
    // Alerta de éxito
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
            Swal.fire({
                title: '¡Registro Exitoso!',
                text: 'El usuario ha sido registrado correctamente.',
                icon: 'success',
                confirmButtonText: 'Aceptar'
            });
          </script>";
    // Limpiar la sesión de la alerta
    unset($_SESSION['showAlert']);
}

// Mostrar alerta de error si existe mensaje de error
if (isset($_SESSION['errorMessage'])) {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
            Swal.fire({
                title: 'Error',
                text: '" . $_SESSION['errorMessage'] . "',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
          </script>";
    unset($_SESSION['errorMessage']); // Limpiar el mensaje de error
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

.col-md-7{
    position: relative;
    padding: 14px;
    display: flex;
    left: 290.5px;
    top: -67px;
    width: 55.5%;
    
}
.A{
    position: relative;
    top: -17px;
    left: 33px;
}

.row2{
    position: relative;
    top: -55px;

}

.col-md-8{
    width: 100%;
}


/* Estilo de los botones */
.botones .btn {
    font-size: 0.85rem; /* Tamaño más pequeño */
    padding: 8px 15px; /* Menor espaciado interno */
    border-radius: 4px; /* Bordes ligeramente redondeados */
    border: 1px solid transparent; /* Sin borde visible por defecto */
    transition: all 0.3s ease; /* Transición suave */
    cursor: pointer; /* Indicador de clic */
}

/* Botón "Agregar" */
.btn-agregar {
    background-color: #007bff; /* Azul corporativo */
    color: white; /* Texto blanco */
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

    <div class="menu-icon" onclick="toggleMenu()">
        <div></div>
        <div></div>
        <div></div>
    </div>

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
            <li><a href="Registro.php"><i class="fas fa-users"></i> Registro</a></li>
            <li><a href="AGREGAR.php"><i class="fas fa-user-plus"></i> Agregar</a></li>
            <li><a href="TablaDeEnfermeria.php"><i class="fas fa-user-md"></i> Enfermera/o</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out"></i> Salir</a></li>
            </ul>
        <div class="footer-menu">
            <span class="cepva">CEPVA</span>
        </div>
    </div>

    <div class="area">

    <h2 class="titulo-formulario">Registrar al Docente</h2><br>
    <form method="POST">
        <div class="row">
            <div class="col-md-6">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre" required>
        </div>
        <div class="col-md-6">
            <label for="apellido">Apellido</label>
            <input type="text" id="apellido" name="apellido" class="form-control" placeholder="Apellidos" required>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="edad">Edad</label>
            <input type="number" id="edad" name="edad" class="form-control" placeholder="Edad" required>
        </div>
    </div>
    <div class="row">
        <div class="col-md-7">
            <label for="area" class="A">Área</label>
            <select id="area" name="area" class="form-control" required>
                <option value="">Seleccione una opción</option>
                <option value="basica">Básica</option>
                <option value="secundaria">Secundaria</option>
            </select>
        </div>
    </div>
    <div class="row2">
        <div class="col-md-8">
            <label for="motivo">Motivo por el que fue atendido</label>
            <textarea id="motivo" name="motivo" class="form-control" placeholder="Describa el motivo" required></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <label for="sintomas">Síntomas</label>
            <textarea id="sintomas" name="sintomas" class="form-control" placeholder="Describa los síntomas" required></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <label for="medicamentos">Medicamentos</label>
            <textarea id="medicamentos" name="medicamentos" class="form-control" placeholder="Medicamentos prescritos" required></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <label for="procedimiento">Procedimiento</label>
            <textarea id="procedimiento" name="procedimiento" class="form-control" placeholder="Procedimiento realizado" required></textarea>
        </div>
    </div>
    <div class="botones">
        <button type="submit" class="btn btn-agregar">Registrar</button>
        <button type="reset" class="btn btn-cancelar">Cancelar</button>
    </div>
</form>
<?php
    // Mostrar alerta si la sesión está configurada
    if (isset($_SESSION['showAlert']) && $_SESSION['showAlert']) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
                Swal.fire({
                    title: '¡Registro Exitoso!',
                    text: 'El usuario ha sido registrado correctamente.',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                });
              </script>";
        unset($_SESSION['showAlert']); // Limpiar la variable de sesión
    }
    ?>

</div>
    <div class="contenedor">
        <h1>Enfermería </h1>
        <img src="logo2.png" alt="" class="logocepva">

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