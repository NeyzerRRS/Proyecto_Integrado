<?php
include_once "../conexionesBD.php";
$conexion = conectarBD();

session_start();
$id_usuario = $_SESSION['id_usuario'];
$fecha = date("Y-m-d");
$status = 1;

$sql_venta = "INSERT INTO ventas (id_usuario, fecha, status) VALUES ('$id_usuario', '$fecha', '$status')";
if ($conexion->query($sql_venta) === TRUE) {
    $id_venta = $conexion->insert_id;

    $numProductos = $_POST['numProductos'];
echo '<pre>';
print_r($_POST);
echo '</pre>';
    for ($i = 1; $i <= $numProductos; $i++) {
        $id_producto = $_POST["idProducto_$i"];
        $cantidad = $_POST["cantidad_$i"];

        $sql_detalle = "INSERT INTO detalle_venta (id_venta, id_producto, cantidad, status) 
                        VALUES ('$id_venta', '$id_producto', '$cantidad', '$status')";
        
        if ($conexion->query($sql_detalle) === TRUE) {
            $sql_actualizar = "UPDATE producto SET existencia = existencia - $cantidad WHERE id_producto = '$id_producto'";
            if (!$conexion->query($sql_actualizar)) {
                die("Error al actualizar la existencia: " . $conexion->error);
            }
        } else {
            die("Error al registrar el detalle: " . $conexion->error);
        }
    }

    echo "Venta registrada correctamente con ID: $id_venta";
} else {
    die("Error al registrar la venta: " . $conexion->error);
}

$conexion->close();
?>
