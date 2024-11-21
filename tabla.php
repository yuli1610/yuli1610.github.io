<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "producto");

if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

// Eliminar producto
if (isset($_GET['eliminar'])) {
    $idProducto = $_GET['eliminar'];
    $sqlDelete = "DELETE FROM produ WHERE id = ?";
    $stmtDelete = $conexion->prepare($sqlDelete);
    $stmtDelete->bind_param("i", $idProducto);
    $stmtDelete->execute();
    header("Location: tabla.php");
    exit();
}

// Verificar si se está editando un producto
$nombre = '';
$cantidad = '';
$idProductoEditar = null;

if (isset($_GET['editar'])) {
    $idProductoEditar = $_GET['editar'];
    $sql = "SELECT * FROM produ WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $idProductoEditar);
    $stmt->execute();
    $resultado = $stmt->get_result();
    if ($producto = $resultado->fetch_assoc()) {
        $nombre = $producto['nombre'];
        $cantidad = $producto['cantidad'];
    }
}

// Actualizar producto
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['actualizar'])) {
    $idProducto = $_POST['id'];
    $nombreProducto = $_POST['nombre'];
    $cantidad = $_POST['cantidad'];

    $sqlUpdate = "UPDATE produ SET nombre = ?, cantidad = ? WHERE id = ?";
    $stmtUpdate = $conexion->prepare($sqlUpdate);
    $stmtUpdate->bind_param("sii", $nombreProducto, $cantidad, $idProducto);
    $stmtUpdate->execute();
    header("Location: tabla.php");
    exit();
}


$busqueda = isset($_GET['buscar']) ? $_GET['buscar'] : '';

// Paginación
$porPagina = 5; 
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($pagina - 1) * $porPagina;

// Consulta para obtener productos con búsqueda y paginación
$sql = "SELECT * FROM produ WHERE nombre LIKE ? LIMIT ? OFFSET ?";
$stmt = $conexion->prepare($sql);
$busquedaLike = '%' . $busqueda . '%';
$stmt->bind_param("sii", $busquedaLike, $porPagina, $offset);
$stmt->execute();
$resultado = $stmt->get_result();

// Obtener el número total de productos
$sqlTotal = "SELECT COUNT(*) as total FROM produ WHERE nombre LIKE ?";
$stmtTotal = $conexion->prepare($sqlTotal);
$stmtTotal->bind_param("s", $busquedaLike);
$stmtTotal->execute();
$totalProductos = $stmtTotal->get_result()->fetch_assoc()['total'];
$totalPaginas = ceil($totalProductos / $porPagina);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Productos</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="tabla.css">
    <style>
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        h1{
            color: white;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        td {
            background-color: #000; /* Fondo negro */
            color: white; /* Texto blanco */
        }

        a {
            text-decoration: none;
            color: #000;
            padding: 5px 10px;
            border-radius: 5px;
        }

        a:hover {
            background-color: #ddd;
        }

        .pagination a {
            margin: 0 5px;
            text-decoration: none;
            padding: 5px 10px;
            border: 1px solid #ddd;
        }

        .pagination a.active {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>

    <center><h1>Tabla de Productos</h1></center>

    <!-- Formulario de búsqueda -->
    <form method="GET" style="text-align: center; margin: 20px;">
        <input type="text" name="buscar" placeholder="Buscar producto..." value="<?php echo htmlspecialchars($busqueda); ?>">
        <button type="submit">Buscar</button>
    </form>

    <!-- Botón para volver a agregar productos -->
    <div style="text-align: center; margin-bottom: 20px;">
        <a href="index.php" style="background-color: #4CAF50; color: white; padding: 10px 20px; border-radius: 5px;">Agregar Productos</a>
    </div>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Cantidad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($producto = $resultado->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($producto['cantidad']); ?></td>
                    <td>
                        <a href="tabla.php?editar=<?php echo $producto['id']; ?>">✏️</a> 
                        |
                        <a href="#" onclick="confirmarEliminar(<?php echo $producto['id']; ?>)">❌</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="pagination" style="text-align: center; margin: 20px;">
        <?php for ($i = 1; $i <= $totalPaginas; $i++) { ?>
            <a href="tabla.php?pagina=<?php echo $i; ?>&buscar=<?php echo urlencode($busqueda); ?>" 
               class="<?php echo $pagina == $i ? 'active' : ''; ?>">
                <?php echo $i; ?>
            </a>
        <?php } ?>
    </div>

    <?php if ($idProductoEditar !== null) { ?>
        <center>
            <h2>Editar Producto</h2>
            <form action="tabla.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $idProductoEditar; ?>">
                <label for="nombre">Nombre del Producto:</label><br><br>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required><br><br>
                <label for="cantidad">Cantidad:</label><br><br>
                <input type="number" id="cantidad" name="cantidad" value="<?php echo htmlspecialchars($cantidad); ?>" required><br><br>
                <button type="submit" name="actualizar">Actualizar</button>
            </form>
        </center>
    <?php } ?>

    <script>
        function confirmarEliminar(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "No podrás deshacer esta acción.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `tabla.php?eliminar=${id}`;
                }
            });
        }
    </script>

</body>
</html>
