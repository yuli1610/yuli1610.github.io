<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    // Nombre de la base de datos y credenciales de conexión
    $db = 'enfermeria'; // Sustituir con el nombre real de la base de datos
    $conexion = new PDO("mysql:host=localhost;dbname=$db", "root", ""); // Cambiar según tu configuración
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión exitosa a la base de datos.<br>"; // Confirmación de la conexión

} catch (PDOException $e) {
    // En caso de error de conexión
    echo "Error de conexión: " . $e->getMessage();
    exit();
}
?>


