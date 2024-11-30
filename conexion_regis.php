<?php
$host = 'localhost';
$dbname = 'enfermeria';
$username = 'root';
$password = '';

try {
    // Conexión con configuración UTF-8
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    
    // Establecer el modo de error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Establecer el tipo de base de datos como UTF-8 para manejar caracteres especiales
    $pdo->exec("SET NAMES 'utf8'");
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET NAMES 'utf8'");

    // Verificar que la base de datos está accesible
    $query = $pdo->query("SELECT 1");
    if ($query) {
        echo "Conexión exitosa a la base de datos.";
    } else {
        echo "No se pudo verificar la conexión.";
    }
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

?>


