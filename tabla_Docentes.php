<!DOCTYPE html>
<lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Lateral Profesional</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ionicons@5.5.2/dist/css/ionicons.min.css">\
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <link rel="stylesheet" href="pag2.css">
<a href="exportar_excel.php" class="btn btn-success">Exportar a Excel</a>

    <table id="studentTable" class="table table-striped table-bordered">

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

/* Estilo general de la tabla */
.table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    table-layout: fixed; /* Evita que las celdas se expandan demasiado */
}

/* Encabezado de la tabla con color cambiado */
.table th {
    background-color: #eaf2f8; /* Color para los encabezados */
    color: #2C3E50; /* Color del texto en los encabezados */
    text-align: left;
    padding: 12px;
    font-weight: bold;
    font-size: 16px;
}

/* Celdas de la tabla */
.table td {
    padding: 12px;
    text-align: left;
    font-size: 14px;
    border-bottom: 1px solid #ddd; /* Borde debajo de las celdas */
}

/* Fila alterna con un color más claro */
.table tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

/* Efecto hover en las filas */
.table tbody tr:hover {
    background-color: #f1f1f1;
    cursor: pointer;
}

/* Estilo de los botones */
.table .btn {
    margin: 0 5px;
    padding: 6px 12px;
    font-size: 14px;
    border-radius: 5px;
    transition: transform 0.2s;
}

/* Hover en botones */
.table .btn:hover {
    transform: translateY(-2px);
}

/* Iconos en los botones */
.table .btn i {
    margin-right: 5px;
}

/* Borde de la tabla */
.table-bordered {
    border: 1px solid #ddd;
}

.table-bordered th, .table-bordered td {
    border: 1px solid #ddd;
    
}

/* Estilos para hacer la tabla responsive */
@media (max-width: 768px) {
    .table {
        display: block;
        overflow-x: auto; /* Permite que la tabla se desplace horizontalmente */
        white-space: nowrap; /* Evita que el texto se ajuste a la línea */
    }
    .table th, .table td {
        font-size: 12px; /* Tamaño de fuente más pequeño para pantallas pequeñas */
        padding: 8px; /* Reduce el padding para que quepa mejor en pantallas pequeñas */

    }
}

/* Para pantallas muy pequeñas, como móviles (menos de 480px) */
@media (max-width: 480px) {
    .table {
        font-size: 10px; /* Font size aún más pequeño */
    }
    .table th, .table td {
        padding: 6px; /* Menos padding para aprovechar mejor el espacio */
    }
}

        /* Contenedor del campo de búsqueda */
        .busqueda-container {
            margin-top: 30px; /* Separa un poco más el input de búsqueda */
            text-align: center; /* Centra el input */
            z-index: 999; /* Asegura que esté por encima de otros elementos */
            position: relative; /* Asegura que el z-index funcione */
        }

        

        h4 {
    font-family: 'Arial', sans-serif; /* Fuente moderna y clara */
    font-size: 28px; /* Tamaño reducido para hacerlo más pequeño */
    font-weight: bold; /* Negrita para énfasis */
    color: #2C3E50; /* Un color oscuro, elegante */
    text-align: center; /* Alineación centrada */
    text-transform: uppercase; /* Mayúsculas para un toque más profesional */
    letter-spacing: 2px; /* Espaciado entre letras */
    margin-top: 40px; /* Espacio superior */
    margin-bottom: 20px; /* Espacio inferior */
    position: relative;
    transition: transform 0.3s ease, color 0.3s ease; /* Efecto de transición */
}

h4:hover {
    transform: scale(1.1); /* Efecto de zoom */
    color: #3498db; /* Cambia el color cuando se pasa el ratón */
}

/* El pseudo-elemento ::after ha sido eliminado */

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
        <li><a href="Registro.php"><i class="fas fa-users"></i> Registro</a></li>
        <li><a href="AGREGAR.php"><i class="fas fa-user-plus"></i>Agregar</a></li>
        <li><a href="TablaDeEnfermeria.php"><i class="fas fa-user-md"></i>Enfermera/o</a></li>
        <li><a href="logout.php"><i class="fas fa-sign-out"></i>Salir</a></li>
        </ul>
    <div class="footer-menu">
        <span class="cepva">CEPVA</span>
    </div>
</div>
<div class="contenedor">
    <h1>Enfermería </h1>
    <img src="logo2.png" alt="" class="logocepva">
</div>
<br><br><br><br><br>
<h4>Registro de Docentes</h4>
<br>
<!-- Contenedor para la búsqueda -->
<input class="search" class="form-control shadow bg-body rounded" id="myInput" type="text" placeholder="Buscar..." style="margin: 5px">
<img  class="img" src="buscar.png" alt=""><br><br>.


<style>
    .search{
        width: 400px;
        position: relative;
        left: 460px;
    }
    .img{
        width: 35px;
        height: 35px;
        position: relative;
        bottom: -10px;
        left: 10px;
        top: 5px;
    }

    .
</style>
<?php 
// Conexión a la base de datos
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'enfermeria';

$conn = new mysqli($host, $username, $password, $dbname);

// Verificar si hay error en la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta a la base de datos para obtener solo los campos visibles
$sql = "SELECT nombre, apellido, edad, area FROM docentes";
$result = $conn->query($sql);

// Verificar si hay registros
if ($result->num_rows > 0) {
    // Botón para exportar todos los registros a Excel
    echo "<a href='Do_excel_todos.php' class='btn btn-success'>
            <i class='fas fa-file-excel'></i> Exportar Todos a Excel
          </a>";


    // Generar la tabla con los registros
    echo "<table class='table table-striped table-bordered'>";
    echo "<thead class='thead-dark'>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Edad</th>
                <th>Área</th>
                <th>Acciones</th>
            </tr>
          </thead>";
    echo "<tbody id='myTable' class='table-body'>";
    
    // Mostrar los datos de los docentes
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['nombre']) . "</td>";
        echo "<td>" . htmlspecialchars($row['apellido']) . "</td>";
        echo "<td>" . htmlspecialchars($row['edad']) . "</td>";
        echo "<td>" . htmlspecialchars($row['area']) . "</td>";
        
        // Botones de acción (editar, eliminar, exportar a Excel)
        echo "<td>
            <!-- Icono de Editar -->
            <a href='editar_docente.php?nombre=" . urlencode($row['nombre']) . "&apellido=" . urlencode($row['apellido']) . "' class='edit'>
                <i class='fas fa-edit'></i>
            </a> 
            <!-- Icono de Eliminar -->
            <a href='#' class='delete' onclick='showDeleteModal(\"" . addslashes($row['nombre']) . "\", \"" . addslashes($row['apellido']) . "\")'>
                 <i class='fas fa-trash-alt'></i>
                 </a>
            <!-- Icono de Exportar a Excel para un solo registro -->
            <a href='exportar_excel_Do.php?nombre=" . urlencode($row['nombre']) . "&apellido=" . urlencode($row['apellido']) . "' class='export'>
                <i class='fas fa-file-excel'></i>
            </a>
        </td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
} else {
    echo "<p class='text-center' id='noResultsMessage'>No hay docentes registrados.</p>";
}

// Cerrar la conexión
$conn->close();
?>

<script>
    document.getElementById('myInput').addEventListener('keyup', function () {
        var input = this.value.toLowerCase();
        var rows = document.querySelectorAll('#myTable tr');

        rows.forEach(function (row) {
            var cells = row.getElementsByTagName('td');
            var found = false;

            for (var i = 0; i < cells.length; i++) {
                if (cells[i].textContent.toLowerCase().includes(input)) {
                    found = true;
                    break;
                }
            }

            // Mostrar u ocultar fila
            row.style.display = found ? '' : 'none';
        });
    });
</script>

<script>
    function showDeleteModal(nombre, apellido) {
        const deleteUrl = `eliminar.php?nombre=${encodeURIComponent(nombre)}&apellido=${encodeURIComponent(apellido)}`;
        document.getElementById('deleteStudentBtn').setAttribute('href', deleteUrl);

        // Mostrar el modal de confirmación
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }
</script>
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirmación de Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar a este docente?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a href="#" id="deleteStudentBtn" class="btn btn-danger">Eliminar</a>
            </div>
        </div>
    </div>
</div>

<div class="pagination-container">
  <ul class="pagination">
    <li><a href="Registro.php">1</a></li>
    <li><a href="tabla_Docentes.php">2</a></li>
  </ul>
</div>
 <style>
 .pagination-container {
  text-align: center; /* Centra la paginación */
  margin-top: 20px; /* Espacio entre la tabla y la paginación */
}

.pagination {
  list-style: none;
  display: inline-flex;
  padding: 0;
  margin: 0;
}

.pagination li {
  margin: 0 3px; /* Espacio reducido entre los botones */
}

.pagination a {
  display: inline-block;
  padding: 4px 10px; /* Botones más pequeños */
  background-color: #375375; /* Nuevo color de fondo */
  color: white; /* Color del texto */
  text-decoration: none;
  border-radius: 3px; /* Bordes más sutiles */
  transition: background-color 0.3s; /* Efecto suave al pasar el mouse */
  font-size: 14px; /* Tamaño de fuente más pequeño */
}

.pagination a:hover {
  background-color: #2c4d61; /* Color ligeramente más oscuro al pasar el mouse */
}

.pagination a:active {
  background-color: #213b4d; /* Color más oscuro al hacer clic */
}

.pagination .disabled {
  background-color: #ddd; /* Fondo para elementos deshabilitados */
  cursor: not-allowed; /* Cambia el cursor cuando no se puede hacer clic */
}

.pagination .active a {
  background-color: #213b4d; /* Color para la página activa */
  pointer-events: none; /* No permite hacer clic en la página activa */
}

 </style>

<!-- Footer -->
<footer>
    <p>© 2024 Todos los derechos reservados. <a href="https://edoplat.com/">CEPVA</a> | <a href="#">Manual</a></p>
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


<script>
// Función para mostrar el modal de confirmación de eliminación
function showDeleteModal(nombre, apellido) {
    // Mostrar el modal de confirmación
    Swal.fire({
        title: '¿Estás seguro?',
        text: "El docente " + nombre + " " + apellido + " será eliminado permanentemente.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'No, cancelar'
    }).then((result) => {
        // Si el usuario confirma la eliminación
        if (result.isConfirmed) {
            // Hacer la solicitud AJAX para eliminar al docente
            fetch('eliminar_Docente.php?nombre=' + encodeURIComponent(nombre) + '&apellido=' + encodeURIComponent(apellido), {
                method: 'GET' // Usamos GET para enviar los parámetros
            })
            .then(response => response.json()) // Esperamos la respuesta como JSON
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        title: 'Eliminado',
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        // Redirigir a la página de tabla de docentes
                        window.location.href = 'tabla_Docentes.php';  // Redirige a la página correcta
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: data.message,
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un problema al intentar eliminar al docente.',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            });
        }
    });
}
</script>


</body>
</html>
