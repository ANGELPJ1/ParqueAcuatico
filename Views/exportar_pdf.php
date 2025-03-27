<?php
require_once('../TCPDF-main/tcpdf.php');
require '../Conexion_BD/bd.php';

// Crear instancia de TCPDF
$pdf = new TCPDF();
$pdf->SetAutoPageBreak(TRUE, 10);
$pdf->AddPage();

// Estilos CSS para replicar Bootstrap
$css = '
<style>
    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }
    th {
        background-color: #343a40;
        color: white;
        padding: 8px;
        text-align: center;
        font-weight: bold;
    }
    td {
        padding: 8px;
        border: 1px solid #ddd;
        text-align: center;
    }
    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    h2 {
        text-align: center;
        font-size: 16px;
        margin-bottom: 10px;
    }
    .group-header {
        background-color: #e9ecef;
        font-weight: bold;
        padding: 6px;
        text-align: left;
        font-size: 14px;
    }
</style>';

// Título del PDF
$pdf->SetFont('helvetica', '', 14);
$pdf->Cell(0, 10, 'Reporte de Órdenes', 0, 1, 'C');

// Obtener los datos de la base de datos
$query = "
    SELECT o.id_orden, c.codigo, o.fecha, o.total, d.producto, d.cantidad, d.precio_unitario, d.subtotal 
    FROM ordenes o
    JOIN clientes c ON o.id_cliente = c.id_cliente
    JOIN detalles_orden d ON o.id_orden = d.id_orden
    ORDER BY o.fecha ASC
";
$result = $conn->query($query);

$html = $css; // Iniciar con los estilos CSS

$codigo_actual = ''; // Variable para controlar los grupos

while ($row = $result->fetch_assoc()) {
    if ($codigo_actual != $row['codigo']) {
        // Si cambia el código, agregamos un encabezado de grupo
        if ($codigo_actual != '') {
            $html .= '</tbody></table>'; // Cerrar tabla anterior
        }
        $html .= '<h2 class="group-header">Grupo de Órdenes con Código: ' . $row['codigo'] . '</h2>
        <table border="1">
            <thead>
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
            <tbody>';
        $codigo_actual = $row['codigo'];
    }

    // Agregar filas de datos
    $html .= '<tr>
                <td>' . $row['id_orden'] . '</td>
                <td>' . $row['codigo'] . '</td>
                <td>' . $row['fecha'] . '</td>
                <td>$' . number_format($row['total'], 2) . '</td>
                <td>' . $row['producto'] . '</td>
                <td>' . $row['cantidad'] . '</td>
                <td>$' . number_format($row['precio_unitario'], 2) . '</td>
                <td>$' . number_format($row['subtotal'], 2) . '</td>
              </tr>';
}

// Cerrar la última tabla
$html .= '</tbody></table>';

// Escribir HTML con estilos en el PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Cerrar conexión a la base de datos
$conn->close();

// Descargar el archivo PDF
$pdf->Output('ordenes.pdf', 'D');
?>