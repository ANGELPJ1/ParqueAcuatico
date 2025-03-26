<?php
require 'Conexion_BD/bd.php';

$usuario = "admin";
$password = password_hash("123456", PASSWORD_BCRYPT);

$stmt = $conn->prepare("INSERT INTO administradores (usuario, password) VALUES (?, ?)");
$stmt->bind_param("ss", $usuario, $password);
$stmt->execute();
$stmt->close();
$conn->close();

echo "Usuario administrador creado con éxito.";
?>