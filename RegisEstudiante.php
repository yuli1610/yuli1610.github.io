<?php
session_start(); // Iniciar sesión para usar $_SESSION

include 'conexion_regis.php'; // Conexión a la base de datos

$showAlert = false; // Variable para verificar si mostrar la alerta

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Recibir los datos del formulario
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $edad = $_POST['edad'];
        $aula = $_POST['aula'];
        $seccion = $_POST['seccion'];
        $sexo = $_POST['sexo'];
        $telefono_madre = $_POST['telefono_madre'];
        $telefono_padre = $_POST['telefono_padre'];
        $telefono_tutor = $_POST['telefono_tutor'];
        $nombre_completo = $_POST['nombre_completo'];
        $motivo = $_POST['motivo'];
        $sintomas = $_POST['sintomas'];
        $medicamentos = $_POST['medicamentos'];
        $procedimiento = $_POST['procedimiento'];

        // Consulta de inserción en la base de datos
        $sql = "INSERT INTO estudiantes_enfermeria 
                (nombre, apellido, edad, aula, seccion, sexo, telefono_madre, telefono_padre, telefono_tutor, nombre_completo, motivo, sintomas, medicamentos, procedimiento)
                VALUES (:nombre, :apellido, :edad, :aula, :seccion, :sexo, :telefono_madre, :telefono_padre, :telefono_tutor, :nombre_completo, :motivo, :sintomas, :medicamentos, :procedimiento)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':edad', $edad);
        $stmt->bindParam(':aula', $aula);
        $stmt->bindParam(':seccion', $seccion);
        $stmt->bindParam(':sexo', $sexo);
        $stmt->bindParam(':telefono_madre', $telefono_madre);
        $stmt->bindParam(':telefono_padre', $telefono_padre);
        $stmt->bindParam(':telefono_tutor', $telefono_tutor);
        $stmt->bindParam(':nombre_completo', $nombre_completo);
        $stmt->bindParam(':motivo', $motivo);
        $stmt->bindParam(':sintomas', $sintomas);
        $stmt->bindParam(':medicamentos', $medicamentos);
        $stmt->bindParam(':procedimiento', $procedimiento);

        $stmt->execute();

        // Establecer la sesión para mostrar la alerta
        $_SESSION['showAlert'] = true;

        // Redirigir para evitar que el formulario se envíe múltiples veces
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } catch (PDOException $e) {
        // Si ocurre un error en la consulta, mostrarlo en la consola
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
                Swal.fire({
                    title: 'Error',
                    text: 'Error al registrar estudiante: " . $e->getMessage() . "',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
              </script>";
    }
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js"></script>

    <link rel="stylesheet" href="pag2.css"><head>
</head>

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
    width: 10%;
}

.btn-agregar:hover {
    background-color: #0056b3; /* Azul más oscuro al pasar el mouse */
}

/* Botón "Cancelar" */
.btn-cancelar {
    width: 10%;
    background-color: #6c757d;
    color: white;
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

.titulo-formulario{
    position: relative;
    top: -170px;
    text-align: center;
}

form .form-label {
  display: block; /* Asegura que el label sea un bloque */
  transform: translateY(-145px); /* Mueve hacia arriba */
}

form .form-control, 
form select, 
form textarea {
  transform: translateY(-150px); /* Mueve los inputs hacia arriba */
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

    <h2 class="titulo-formulario">Registrar al Estudiante</h2>
<form action="#" method="post">
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre" required>
        </div>
        <div class="col-md-6">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" id="apellido" name="apellido" class="form-control" placeholder="Apellido" required>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="edad" class="form-label">Edad</label>
            <input type="text" id="edad" name="edad" class="form-control" placeholder="Edad" required>
        </div>
        <div class="col-md-6">
            <label for="aula" class="form-label">Aula</label>
            <input type="text" id="aula" name="aula" class="form-control" placeholder="Aula" required>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="seccion" class="form-label">Sección</label>
            <input type="text" id="seccion" name="seccion" class="form-control" placeholder="Sección" required>
        </div>
        <div class="col-md-6">
            <label for="sexo" class="form-label">Sexo</label>
            <select id="sexo" name="sexo" class="form-control" required>
                <option value="">Seleccione el sexo</option>
                <option value="masculino">Masculino</option>
                <option value="femenino">Femenino</option>
            </select>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-4">
            <label for="telefonoMadre" class="form-label">Teléfono de la Madre</label>
            <input type="tel" id="telefono_madre" name="telefono_madre" class="form-control" placeholder="Teléfono de la Madre">
        </div>
        <div class="col-md-4">
            <label for="telefonoPadre" class="form-label">Teléfono del Padre</label>
            <input type="tel" id="telefono_padre" name="telefono_padre" class="form-control" placeholder="Teléfono del Padre">
        </div>
        <div class="col-md-4">
            <label for="telefonoTutor" class="form-label">Teléfono del Tutor</label>
            <input type="tel" id="telefono_tutor" name="telefono_tutor" class="form-control" placeholder="Teléfono del Tutor">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-12">
            <label for="nombreCompleto" class="form-label">Nombre Completo</label>
            <input type="text" id="nombreCompleto" name="nombre_completo" class="form-control" placeholder="Nombre Completo" required>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-12">
            <label for="motivo" class="form-label">Motivo por el que fue atendido</label>
            <textarea id="motivo" name="motivo" class="form-control" rows="3" placeholder="Describa el motivo" required></textarea>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-12">
            <label for="sintomas" class="form-label">Síntomas</label>
            <textarea id="sintomas" name="sintomas" class="form-control" rows="3" placeholder="Describa los síntomas" required></textarea>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-12">
            <label for="medicamentos" class="form-label">Medicamentos suministrados</label>
            <textarea id="medicamentos" name="medicamentos" class="form-control" rows="3" placeholder="Especifique los medicamentos" required></textarea>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-12">
            <label for="procedimiento" class="form-label">Procedimiento médico</label>
            <textarea id="procedimiento" name="procedimiento" class="form-control" rows="3" placeholder="Detalle el procedimiento médico" required></textarea>
        </div>
    </div>

    <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-primary me-3">Agregar</button>
        <button type="reset" class="btn btn-secondary">Cancelar</button>
    </div>
 </div>
</form>

<?php
if (isset($_SESSION['showAlert']) && $_SESSION['showAlert'] == true) {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
            Swal.fire({
                title: '¡Registro Exitoso!',
                text: 'El estudiante ha sido registrado correctamente.',
                icon: 'success',
                confirmButtonText: 'Aceptar'
            });
          </script>";
    unset($_SESSION['showAlert']); // Limpiar la variable de sesión
}
?>

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