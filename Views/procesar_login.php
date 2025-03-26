<?php
session_start(); // Asegúrate de iniciar la sesión

require '../Conexion_BD/bd.php'; // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);

    if (empty($usuario) || empty($password)) {
        echo json_encode(["success" => false, "message" => "Todos los campos son obligatorios."]);
        exit();
    }

    // Consultar en la base de datos
    $stmt = $conn->prepare("SELECT id_admin, usuario, password FROM administradores WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            // Almacenar los datos del administrador en la sesión
            $_SESSION['admin_id'] = $row['id_admin'];
            $_SESSION['admin_usuario'] = $row['usuario'];

            // Responder con éxito y un mensaje de redirección
            echo json_encode(["success" => true, "message" => "Inicio de sesión exitoso.", "redirect" => "admin_dashboard.php"]);
        } else {
            echo json_encode(["success" => false, "message" => "Contraseña incorrecta."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Usuario no encontrado."]);
    }

    $stmt->close();
    $conn->close();
}
?>