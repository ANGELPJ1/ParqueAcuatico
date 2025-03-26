<?php
session_start(); // Inicia la sesión para destruirla

// Destruir todas las variables de sesión
session_unset();

// Destruir la sesión
session_destroy();

// Redirigir al inicio de la página principal
header("Location: ../index.php"); // Redirige a la página principal de Parqueacuatico
exit();
?>