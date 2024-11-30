<?php
session_start(); // Inicia la sesión

// Destruye todas las variables de sesión
$_SESSION = [];
session_unset();
session_destroy();

// Evita el acceso a páginas protegidas desde el historial del navegador
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Redirige al login
header("Location: index.php");
exit;
?>
