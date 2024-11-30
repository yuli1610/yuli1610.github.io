<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'usuario') {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Usuario</title>
</head>
<body>
    <h1>Bienvenido, Usuario</h1>
    <a href="cerrar_sesion.php">Cerrar Sesión</a>
</body>
</html>
