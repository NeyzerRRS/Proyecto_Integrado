<?php
include "../conexionesBD.php";
$conexion = conectarBD();

$fecha_inicio = $_POST['fecha_inicio'] ?? date('Y-m-d');
$fecha_fin = $_POST['fecha_fin'] ?? $fecha_inicio;
$usuario = $_POST['usuario'] ?? '';

$sql = "SELECT v.id_venta, v.fecha, u.nombre AS usuario, SUM(p.precio * dv.cantidad) AS total ";
$sql .= "FROM usuarios AS u ";
$sql .= "INNER JOIN ventas AS v ON u.id_usuario = v.id_usuario ";
$sql .= "INNER JOIN detalle_venta AS dv ON v.id_venta = dv.id_venta ";
$sql .= "INNER JOIN producto AS p ON dv.id_producto = p.id_producto ";
$sql .= "WHERE v.status = 1 AND dv.status = 1";

if (!empty($fecha_inicio) && empty($fecha_fin)) {
    $sql .= " AND v.fecha = '$fecha_inicio'";
}
if (!empty($fecha_inicio) && !empty($fecha_fin)) {
    $sql .= " AND v.fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'";
}
if (!empty($usuario)) {
    $sql .= " AND usuario_id = '$usuario'";
}

$sql .= " GROUP BY v.id_venta ORDER BY v.fecha ASC";
$resultado = mysqli_query($conexion, $sql);

$total_general = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/style.css">
    <title>Reporte de Ventas</title>
</head>
<body>
    <header>
        <a href="../Index.php"><img src="../Imagenes/Logo-removebg-preview.png" alt="Logo"></a>
        <div class="User">
            <img class="User_icon" src="../Imagenes/IL.png" alt="User Icon">
        </div>
        <h1 class="Inventario">Reporte de Ventas</h1>
    </header>
        <?php include "../Menu.php"; ?><br>

    <?php if ($resultado && $resultado->num_rows > 0){?>
    <table class="Tb-Rv">
        <thead>
            <tr>
                <th style="display: none;">ID Venta</th>
                <th>Fecha</th>
                <th>Usuario</th>
                <th>Importe Total</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($repV = mysqli_fetch_assoc($resultado)) { ?>
            <tr>
                <td style="display: none;"><?php echo $repV['id_venta']; ?></td>
                <td><?php echo $repV['fecha']; ?></td>
                <td><?php echo $repV['usuario']; ?></td>
                <td><?php echo number_format($repV['total'], 2); ?></td>
            </tr>
            <?php $total_general += $repV['total']; ?>
            <?php } ?>   
        </tbody>
    </table>
        <h2 class="Tt-Rv">Total de Ventas: $<?php echo number_format($total_general, 2); ?></h2>
    <?php }
        else{ ?>
            <div class="No_Encontrado">No se encontaron Ventas</div>
    <?php }?>
    <a href="consultar_reporteV.php">
        <button class="btn-Rv" type="submit">Volver</button>
    </a>
</body>
</html>
<?php
mysqli_close($conexion);
?>
