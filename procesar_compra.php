<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'Conexion_BD/bd.php'; // Conexión a la base de datos

$response = ["success" => false, "message" => ""];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = trim($_POST['codigo']);

    if (empty($codigo)) {
        $response["message"] = "Error: Código no válido.";
        echo json_encode($response);
        exit();
    }

    // 1️⃣ Insertar en la tabla clientes (si no existe)
    $stmt = $conn->prepare("INSERT INTO clientes (codigo) VALUES (?) ON DUPLICATE KEY UPDATE codigo=codigo");
    $stmt->bind_param("s", $codigo);
    $stmt->execute();
    $id_cliente = $stmt->insert_id;
    $stmt->close();

    // 2️⃣ Insertar la orden
    $total = 0;
    $stmt = $conn->prepare("INSERT INTO ordenes (id_cliente, total) VALUES (?, 0)");
    $stmt->bind_param("i", $id_cliente);
    $stmt->execute();
    $id_orden = $stmt->insert_id;
    $stmt->close();

    // 3️⃣ Insertar los productos comprados
    $productos = [
        "entradasAdulto" => 180,
        "entradasNino" => 120,
        "sillas" => 30,
        "mesas" => 50,
        "sombrillas" => 50,
        "casaCampanaEspacio" => 350,
        "casaCampana4" => 150,
        "casaCampana8" => 180,
        "casaCampana12" => 220,
        "cabaña4" => 2500,
        "cabaña6" => 3000
    ];

    $stmt = $conn->prepare("INSERT INTO detalles_orden (id_orden, producto, cantidad, precio_unitario, subtotal) 
                           VALUES (?, ?, ?, ?, ?)");

    foreach ($productos as $producto => $precio) {
        if (!empty($_POST[$producto]) && $_POST[$producto] > 0) {
            $cantidad = (int) $_POST[$producto];
            $subtotal = $cantidad * $precio;
            $total += $subtotal;

            $stmt->bind_param("isidd", $id_orden, $producto, $cantidad, $precio, $subtotal);
            $stmt->execute();
        }
    }
    $stmt->close();

    // 4️⃣ Actualizar el total en la tabla ordenes
    $stmt = $conn->prepare("UPDATE ordenes SET total=? WHERE id_orden=?");
    $stmt->bind_param("di", $total, $id_orden);
    $stmt->execute();
    $stmt->close();

    $conn->close();

    // Enviar respuesta JSON
    $response["success"] = true;
    $response["message"] = "¡Compra exitosa! Código: $codigo";

    echo json_encode($response);
    exit();
}
?>