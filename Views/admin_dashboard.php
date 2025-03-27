<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php?page=login");
    exit();
}

require '../Conexion_BD/bd.php';

// Obtener todas las órdenes con sus detalles
$query = "
    SELECT o.id_orden, c.codigo, o.fecha, o.total, d.producto, d.cantidad, d.precio_unitario, d.subtotal 
    FROM ordenes o
    JOIN clientes c ON o.id_cliente = c.id_cliente
    JOIN detalles_orden d ON o.id_orden = d.id_orden
    ORDER BY o.fecha ASC
";
$result = $conn->query($query);

// Agrupar por código de cliente
$ordersGrouped = [];
while ($row = $result->fetch_assoc()) {
    $ordersGrouped[$row['codigo']][] = $row;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
    <link rel="icon" href="../Resources/logo.png" type="image/x-icon">
    <link rel="shortcut icon" href="../Resources/logo.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <style>
        /* Estilos adicionales para mejorar la visualización */
        .group-header {
            font-weight: bold;
            padding: 10px;
            text-align: center;
            font-size: 18px;
        }

        .order-row {
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <h2 class="text-center">Panel de Administrador</h2>
        <!-- Contenedor para los botones alineados a la izquierda -->
        <div class="d-flex justify-content-start mb-3">
            <a href="logout.php" class="btn btn-danger me-2">
                <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
            </a>
            <a href="exportar_pdf.php" class="btn btn-primary">
                <i class="bi bi-file-earmark-pdf"></i> Descargar PDF
            </a>
        </div>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID Orden</th>
                    <th>Código</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $colorIndex = 0;
                $colors = ['#f2f2f2', '#e6f7ff', '#fff0f0', '#fff7e6']; // Colores para los grupos
                foreach ($ordersGrouped as $codigo => $groupedOrders):
                    // Cambiar el color de fondo en cada grupo
                    $color = $colors[$colorIndex % count($colors)];
                    $colorIndex++;
                    ?>
                    <!-- Fila de encabezado para el grupo -->
                    <tr style="background-color: <?php echo $color; ?>;" class="group-header">
                        <td colspan="8">Grupo de Órdenes con Código: <?php echo $codigo; ?></td>
                    </tr>
                    <!-- Ordenes dentro del grupo -->
                    <?php foreach ($groupedOrders as $row): ?>
                        <tr class="order-row">
                            <td><?php echo $row['id_orden']; ?></td>
                            <td><?php echo $row['codigo']; ?></td>
                            <td><?php echo $row['fecha']; ?></td>
                            <td>$<?php echo number_format($row['total'], 2); ?></td>
                            <td><?php echo $row['producto']; ?></td>
                            <td><?php echo $row['cantidad']; ?></td>
                            <td>$<?php echo number_format($row['precio_unitario'], 2); ?></td>
                            <td>$<?php echo number_format($row['subtotal'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>

<?php $conn->close(); ?>