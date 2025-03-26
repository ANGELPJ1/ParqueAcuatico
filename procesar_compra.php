<?php
require 'Conexion_BD/bd.php'; // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = $_POST['codigo']; // Código único generado

    // 1️⃣ Insertar en la tabla clientes (si no existe)
    $sqlCliente = "INSERT INTO clientes (codigo) VALUES ('$codigo') ON DUPLICATE KEY UPDATE codigo=codigo";
    $conn->query($sqlCliente);
    $id_cliente = $conn->insert_id;

    // 2️⃣ Insertar la orden
    $total = 0;
    $sqlOrden = "INSERT INTO ordenes (id_cliente, total) VALUES ($id_cliente, 0)";
    $conn->query($sqlOrden);
    $id_orden = $conn->insert_id;

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

    foreach ($productos as $producto => $precio) {
        if (!empty($_POST[$producto]) && $_POST[$producto] > 0) {
            $cantidad = $_POST[$producto];
            $subtotal = $cantidad * $precio;
            $total += $subtotal;

            $sqlDetalle = "INSERT INTO detalles_orden (id_orden, producto, cantidad, precio_unitario, subtotal) 
                           VALUES ($id_orden, '$producto', $cantidad, $precio, $subtotal)";
            $conn->query($sqlDetalle);
        }
    }

    // 4️⃣ Actualizar el total en la tabla ordenes
    $sqlUpdateTotal = "UPDATE ordenes SET total=$total WHERE id_orden=$id_orden";
    $conn->query($sqlUpdateTotal);

    echo "Compra realizada con éxito. Código: $codigo";
}

$conn->close();
?>