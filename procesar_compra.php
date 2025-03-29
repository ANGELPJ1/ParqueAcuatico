<?php

header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 1);

//require 'Conexion_BD/bd.php'; // Conexión a la base de datos
require './Conexion_BD/bd.php';
//require_once 'tcpdf/tcpdf.php'; // Incluir TCPDF
require_once './TCPDF-main/tcpdf.php';

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

    $items_comprados = []; // Para almacenar los productos en el ticket

    foreach ($productos as $producto => $precio) {
        if (!empty($_POST[$producto]) && $_POST[$producto] > 0) {
            $cantidad = (int) $_POST[$producto];
            $subtotal = $cantidad * $precio;
            $total += $subtotal;

            $stmt->bind_param("isidd", $id_orden, $producto, $cantidad, $precio, $subtotal);
            $stmt->execute();

            // Guardar en el array para el ticket
            $items_comprados[] = [
                "nombre" => $producto,
                "cantidad" => $cantidad,
                "precio" => $precio,
                "subtotal" => $subtotal
            ];
        }
    }
    $stmt->close();

    // 4️⃣ Actualizar el total en la tabla ordenes
    $stmt = $conn->prepare("UPDATE ordenes SET total=? WHERE id_orden=?");
    $stmt->bind_param("di", $total, $id_orden);
    $stmt->execute();
    $stmt->close();

    $conn->close();

    // 5️⃣ Generar el ticket en PDF
    $pdf = new TCPDF();
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    $pdf->AddPage();

    // **Encabezado**
    $pdf->SetFont('Helvetica', 'B', 14);
    $pdf->Cell(0, 10, "Ticket de Compra", 0, 1, 'C');

    $pdf->SetFont('Helvetica', '', 12);
    $pdf->Cell(0, 10, "Código de Cliente: " . $codigo, 0, 1, 'L');
    $pdf->Cell(0, 10, "Número de Orden: " . $id_orden, 0, 1, 'L');
    $pdf->Ln(5);

    // **Tabla de productos**
    $pdf->SetFont('Helvetica', 'B', 12);
    $pdf->Cell(60, 10, "Producto", 1);
    $pdf->Cell(30, 10, "Cantidad", 1);
    $pdf->Cell(40, 10, "Precio Unitario", 1);
    $pdf->Cell(40, 10, "Subtotal", 1);
    $pdf->Ln();

    $pdf->SetFont('Helvetica', '', 12);
    foreach ($items_comprados as $item) {
        $pdf->Cell(60, 10, ucfirst($item['nombre']), 1);
        $pdf->Cell(30, 10, $item['cantidad'], 1);
        $pdf->Cell(40, 10, "$" . number_format($item['precio'], 2), 1);
        $pdf->Cell(40, 10, "$" . number_format($item['subtotal'], 2), 1);
        $pdf->Ln();
    }


    // **Total**
    $pdf->SetFont('Helvetica', 'B', 12);
    $pdf->Cell(130, 10, "Total", 1);
    $pdf->Cell(40, 10, "$" . number_format($total, 2), 1);
    $pdf->Ln();

    // Guardar PDF en servidor
    //$pdf_file = "./Views/ticket_$id_orden.pdf";
    $pdf_file = __DIR__ . "/Views/ticket_$id_orden.pdf";
    $pdf->Output($pdf_file, "F");

    // Enviar respuesta JSON
    $response["success"] = true;
    $response["message"] = "¡Compra exitosa! Código: $codigo";
    //$response["pdf_url"] = $pdf_file; // Enlace al ticket
    $response["pdf_url"] = "http://localhost/ParqueAcuatico/Views/ticket_$id_orden.pdf";

    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(["success" => false, "message" => "Error al generar JSON."]);
        exit;
    }

    echo json_encode($response);
    exit();
}
?>