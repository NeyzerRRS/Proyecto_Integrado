<?php
    include "conexionesBD.php";
    $conexion = conectarBD();
    // Checar conexión
    if(!$conexion) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

    $producto = $_POST['producto'];
    $usuario = $_POST['usuario'];

    $consultaSQL = "SELECT v.id_venta, v.fecha, (dv.cantidad*p.precio) AS Importe, p.nombre AS producto, u.nombre AS usuario ";
    $consultaSQL .= "FROM producto AS p ";
    $consultaSQL .= "INNER JOIN detalle_venta AS dv ON p.id_producto = dv.id_producto ";
    $consultaSQL .= "INNER JOIN ventas AS v ON dv.id_venta = v.id_venta ";
    $consultaSQL .= "INNER JOIN usuarios AS u ON v.id_usuario = u.id_usuario ";
    $consultaSQL .= "WHERE v.status = 1 AND p.status = 1 AND u.status = 1";

    // Filtro por producto y usuario
    if (!empty($producto) && !empty($usuario)) 
    {
        $consultaSQL .= " AND p.id_producto = $producto AND v.id_usuario = $usuario";
    } 
    // Filtro solo por producto
    elseif (!empty($producto)) {
        $consultaSQL .= " AND p.id_producto = $producto";
    }
    // Filtro solo por usuario
    elseif (!empty($usuario)) {
        $consultaSQL .= " AND v.id_usuario = $usuario";
    }

    $resultado = mysqli_query($conexion, $consultaSQL);

    // Verificar si hay resultados
    if ($resultado->num_rows > 0) 
    {
        echo "<h2>Resultados de las Ventas</h2>";
        echo "<table border='2'>";
        echo ("<tr>
            <th>ID Venta</th>
            <th>Fecha</th>
            <th>Importe</th>
            <th>Producto</th>
            <th>Usuario</th>
            </tr>");
        while ($venta = mysqli_fetch_assoc($resultado)) {
            echo "<tr>";
            echo "<td>" . $venta['id_venta'] . "</td>";
            echo "<td>" . $venta['fecha'] . "</td>";
            echo "<td>" . $venta['Importe'] . "</td>";
            echo "<td>" . $venta['producto'] . "</td>";
            echo "<td>" . $venta['usuario'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<h2>No se encontraron ventas con los filtros seleccionados.</h2>";
    }

    // Cerrar la conexión
    mysqli_close($conexion);
?>
