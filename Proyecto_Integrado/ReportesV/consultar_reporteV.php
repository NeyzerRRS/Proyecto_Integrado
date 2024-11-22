<?php
date_default_timezone_set('America/Mexico_City');
setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'Spanish_Spain', 'es_MX.UTF-8');

include "../conexionesBD.php";
$conexion = conectarBD();

$fecha_hoy = date('Y-m-d');
$nombre_dia =  utf8_encode(strftime('%A', strtotime($fecha_hoy)));
$nombre_dia = ucfirst($nombre_dia);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/style.css">
    <title>Consultar Reporte de Ventas</title>
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
    <form class="Fil-Rv" method="POST" action="mostrar_reporteV.php">
        <label class="cont-Rv" for="fecha_inicio">Fecha de Inicio:</label>
        <input class="cont-Rv" type="date" id="fecha_inicio" name="fecha_inicio" value="<?php echo date('Y-m-d'); ?>" required>

        <label class="cont-Rv" for="fecha_fin">Fecha de Fin:</label>
        <input class="cont-Rv" type="date" id="fecha_fin" name="fecha_fin" value="<?php echo $fecha_hoy ?>">

        <label class="cont-Rv" for="usuario">Usuario:</label>
        <select class="cont-Rv" name="usuario" id="usuario">
            <option value="">Todos</option>
            <?php
            $sql_Us = "SELECT id_usuario, nombre FROM usuarios WHERE status = 1";
            try{
            $resultado_Us = mysqli_query($conexion, $sql_Us);
            } catch(mysqli_sql_exception $e){
                die("Error en la consulta: " . $e->getMessage());
            }
            while($usuario = mysqli_fetch_assoc($resultado_Us)) { 
            ?>
            <option value="<?php echo $usuario ['id_usuario']; ?>">
                <?php echo $usuario ["nombre"]; ?>
            </option>
            <?php } ?>
        </select>
        <button class="btn-Rv" type="submit">Buscar</button>
    </form>
    <h2 class="Tt-Rv">Ventas del Día: <?php echo $nombre_dia . ", " . $fecha_hoy; ?></h2>
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
            <?php
            $sql = "SELECT v.id_venta, v.fecha, u.nombre AS usuario, SUM(p.precio * dv.cantidad) AS total
                    FROM usuarios AS u
                    INNER JOIN ventas AS v ON u.id_usuario = v.id_usuario
                    INNER JOIN detalle_venta AS dv ON v.id_venta = dv.id_venta
                    INNER JOIN producto AS p ON dv.id_producto = p.id_producto
                    WHERE v.fecha = '$fecha_hoy'
                    GROUP BY v.id_venta ORDER BY v.fecha ASC";

            $resultado_hoy = mysqli_query($conexion, $sql);
            $total_general = 0;

            while ($row = mysqli_fetch_assoc($resultado_hoy)) {
                echo "<tr>
                        <td style='display: none;' >{$row['id_venta']}</td>
                        <td>{$row['fecha']}</td>
                        <td>{$row['usuario']}</td>
                        <td>" . number_format($row['total'], 2) . "</td>
                    </tr>";
                $total_general += $row['total'];
            }
            ?>
        </tbody>
    </table>
    <h2 class="Tt-Rv">Total del Día: $<?php echo number_format($total_general, 2); ?></h3>
</body>
</html>
<?php
mysqli_close($conexion);
?>