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
    ORDER BY o.fecha DESC
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h2 class="text-center">Panel de Administrador</h2>
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
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id_orden']; ?></td>
                        <td><?php echo $row['codigo']; ?></td>
                        <td><?php echo $row['fecha']; ?></td>
                        <td>$<?php echo number_format($row['total'], 2); ?></td>
                        <td><?php echo $row['producto']; ?></td>
                        <td><?php echo $row['cantidad']; ?></td>
                        <td>$<?php echo number_format($row['precio_unitario'], 2); ?></td>
                        <td>$<?php echo number_format($row['subtotal'], 2); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
    </div>
</body>

</html>

<?php $conn->close(); ?>