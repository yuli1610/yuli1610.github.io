<?php
// Conexión a la base de datos
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'enfermeria';

$conn = new mysqli($host, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta para obtener los usuarios
$sql = "SELECT id, nombre, apellido, contraseña, rol FROM usuarios";
$result = $conn->query($sql);

// Verificar si la consulta fue exitosa
if (!$result) {
    die("Error en la consulta: " . $conn->error);
}
?>

<div class="table-responsive">
    <table class="table table-hover table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Contraseña</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody class="tableBody">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['nombre'] . "</td>";
                    echo "<td>" . $row['apellido'] . "</td>";
                    echo "<td>****</td>";  // Ocultar la contraseña
                    echo "<td>" . $row['rol'] . "</td>";
                    echo "<td>
                            <a href='editar.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm'><i class='fas fa-edit'></i> Editar</a>
                            <a href='eliminar.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='text-center'>No hay usuarios registrados.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php
// Cerrar la conexión
$conn->close();
?>
