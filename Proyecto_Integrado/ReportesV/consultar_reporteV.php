<?php
date_default_timezone_set('America/Mexico_City');
setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'Spanish_Spain', 'es_MX.UTF-8');

include_once "../conexionesBD.php";
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
        <a href="../Home.php"><img src="../Imagenes/Logo-removebg-preview.png" alt="Logo"></a>
        <div class="User">
              <!--QUITAR EL 8080-->
            <form class="User_icon" action="http://localhost:8080/Proyecto_Integrado/logout.php" method="post">
            <button class="Btn">
                <div class="sign"><svg viewBox="0 0 512 512">
                    <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path><svg>
                </div>
            <div class="text">Cerrar sesión</div>
            </button>
        </form>
            <img class="User_icon" src="../Imagenes/IL.png" alt="User Icon">
        </div>
        <h1 class="Inventario">Reporte de Ventas</h1>
    </header>
        <?php include "../Menu.php"; ?><br>
        <?php
        $id_usuario = $_SESSION['id_usuario'];

        // Obtener el rol del usuario desde la base de datos
        $query = "SELECT tipo_usuario AS rol FROM usuarios WHERE id_usuario = $id_usuario";
        $result = $conexion->query($query);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $rol = $row['rol'];
        } else {
            echo "Error al obtener el rol del usuario.";
            session_destroy(); // Cerrar sesión en caso de error crítico
            //Aqui solo borra el 8080 para que furule
            header("Location: http://localhost:8080/Proyecto_Integrado/index.php");
            exit();
        }
        ?>
        <!--Opcional: Manejo adicional según roles-->
        <?php if ($rol == 'Administrativo') {?>
    <form class="Fil-Rv" method="POST" action="mostrar_reporteV.php">
        <label class="cont-Rv" for="fecha_inicio">Fecha de Inicio:</label>
        <input class="cont-Rv" type="date" id="fecha_inicio" name="fecha_inicio" value="<?php echo date('Y-m-d'); ?>"required>

        <label class="cont-Rv" for="fecha_fin">Fecha de Fin:</label>
        <input class="cont-Rv" type="date" id="fecha_fin" name="fecha_fin" value="<?php echo date('Y-m-d'); ?>">

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
            $sql = "SELECT v.id_venta, v.fecha, u.nombre AS usuario, SUM(p.precio * dv.cantidad) AS total ";
            $sql .= "FROM usuarios AS u ";
            $sql .= "INNER JOIN ventas AS v ON u.id_usuario = v.id_usuario ";
            $sql .= "INNER JOIN detalle_venta AS dv ON v.id_venta = dv.id_venta ";
            $sql .= "INNER JOIN producto AS p ON dv.id_producto = p.id_producto ";
            $sql .= "WHERE v.fecha = '$fecha_hoy' ";
            $sql .= "GROUP BY v.id_venta ORDER BY v.fecha ASC";

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
        <?php } elseif ($rol == 'Encargado') {?>
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
            $sql = "SELECT v.id_venta, v.fecha, u.nombre AS usuario, SUM(p.precio * dv.cantidad) AS total ";
            $sql .= "FROM usuarios AS u ";
            $sql .= "INNER JOIN ventas AS v ON u.id_usuario = v.id_usuario ";
            $sql .= "INNER JOIN detalle_venta AS dv ON v.id_venta = dv.id_venta ";
            $sql .= "INNER JOIN producto AS p ON dv.id_producto = p.id_producto ";
            $sql .= "WHERE v.fecha = '$fecha_hoy' ";
            $sql .= "GROUP BY v.id_venta ORDER BY v.fecha ASC";

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
        <?php } else {
            echo "Rol no reconocido.";
            session_destroy();
            header("Location: index.php");
            exit();
        }?>
</body>
</html>
<?php
mysqli_close($conexion);
?>