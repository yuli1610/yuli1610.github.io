<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin</title>
</head>
<body>
    <h1>Bienvenido, Admin</h1>
    <a href="AGREGAR.php">Agregar Usuarios</a>
    <a href="cerrar_sesion.php">Cerrar Sesión</a>
</body>
</html>
