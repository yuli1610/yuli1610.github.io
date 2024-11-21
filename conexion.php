<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "producto");

if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

// Obtención de datos del formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombreProducto = $conexion->real_escape_string($_POST['nombre']);
    $cantidad = (int)$_POST['cantidad'];

    // Validar si existe el producto en la base de datos
    $sql = "SELECT cantidad FROM produ WHERE nombre = '$nombreProducto'";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        // Si el producto existe, restar la cantidad
        $producto = $resultado->fetch_assoc();
        $nuevaCantidad = $producto['cantidad'] - $cantidad;

        if ($nuevaCantidad >= 0) {
            // Actualizar cantidad en la base de datos
            $sqlUpdate = "UPDATE produ SET cantidad = $nuevaCantidad WHERE nombre = '$nombreProducto'";
            if ($conexion->query($sqlUpdate)) {
                echo "<script>
                    Swal.fire({
                        title: 'Producto agregado',
                        text: 'Cantidad descontada correctamente.',
                        icon: 'success'
                    }).then(() => {
                        window.location.href = 'index.php';
                    });
                </script>";
            } else {
                echo "Error al actualizar: " . $conexion->error;
            }
        } else {
            echo "<script>
                Swal.fire({
                    title: 'Error',
                    text: 'Cantidad insuficiente en el inventario.',
                    icon: 'error'
                }).then(() => {
                    window.location.href = 'index.php';
                });
            </script>";
        }
    } else {
        echo "<script>
            Swal.fire({
                title: 'Error',
                text: 'Producto no encontrado.',
                icon: 'error'
            }).then(() => {
                window.location.href = 'index.php';
            });
        </script>";
    }
}

$conexion->close();
?>
