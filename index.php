<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingreso de Productos</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="index.css">
    
    <style>
        footer {
            background-color: #333; 
            color: white;           
            padding: 20px;
            text-align: center;
            position: fixed;        
            width: 100%;            
            bottom: 0;              
            font-size: 14px;
        }

        footer a {
            color: #4a4ad8;       
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline; 
        }
    </style>

    <script>
        function confirmarEnvio(event) {
            event.preventDefault(); 

            Swal.fire({
                title: '¿Agregar producto?',
                text: '¿Estás seguro de que quieres agregar este producto?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, agregar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('formProducto').submit(); // Enviar formulario si se confirma
                }
            });
        }
    </script>
</head>
<body>

    <div style="padding-bottom: 60px;"> <!-- Espacio para el footer -->
    </div>

    <!-- Pie de página -->
    <footer>
        © 2024 Mi Tienda. Todos los derechos reservados. | 
        <a href="politica-privacidad.php">Política de Privacidad</a> | 
        <a href="contacto.php">Contacto</a>
    </footer>

    <div class="area"></div>
    <img src="1.png" alt="" class="img">
    <div class="vertical-line"></div>
    <div class="llena">

    <center><h1 class="text">Ingreso de Productos</h1></center>

    <?php
    // Conexión a la base de datos
    $conexion = new mysqli("localhost", "root", "", "producto");

    if ($conexion->connect_error) {
        die("Error en la conexión: " . $conexion->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nombreProducto = $_POST['nombre'];
        $cantidad = (int) $_POST['cantidad'];

        // Validar si el producto ya existe
        $sql = "SELECT cantidad FROM produ WHERE nombre = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("s", $nombreProducto);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            // Producto existente: actualizar cantidad
            $producto = $resultado->fetch_assoc();
            $nuevaCantidad = $producto['cantidad'] + $cantidad;

            $sqlUpdate = "UPDATE produ SET cantidad = ? WHERE nombre = ?";
            $stmtUpdate = $conexion->prepare($sqlUpdate);
            $stmtUpdate->bind_param("is", $nuevaCantidad, $nombreProducto);
            $stmtUpdate->execute();
        } else {
            // Producto nuevo: insertarlo
            $sqlInsert = "INSERT INTO produ (nombre, cantidad) VALUES (?, ?)";
            $stmtInsert = $conexion->prepare($sqlInsert);
            $stmtInsert->bind_param("si", $nombreProducto, $cantidad);
            $stmtInsert->execute();
        }

        // Notificación de éxito
        echo "<script>
            Swal.fire({
                title: 'Producto agregado',
                text: 'El producto se ha añadido correctamente.',
                icon: 'success'
            }).then(() => {
                window.location.href = 'tabla.php'; // Redirigir a la tabla
            });
        </script>";
        exit();
    }
    ?>

    <form id="formProducto" action="" method="POST" onsubmit="confirmarEnvio(event)">
        <div class="formu">
            <label for="nombre">Nombre del Producto:</label><br><br>
            <input type="text" id="nombre" name="nombre" required>
            <br><br>

            <label for="cantidad">Cantidad:</label><br><br>
            <input type="number" id="cantidad" name="cantidad" required>
            <br><br>
            <button type="submit" class="b1">Agregar</button>
            <button type="reset" class="b2">Cancelar</button>
        </div>
    </form>

    <button class="button1" onclick="window.location.href='productos.php'">Ver Productos</button>
    <button class="button2" onclick="window.location.href='tabla.php'">Tabla de Productos</button>

    </div>

</body>
</html>
