<?php
include_once "../conexionesBD.php";
$conexion = conectarBD();

session_start();
$id_usuario = $_SESSION['id_usuario'];  // Obtener el ID del usuario desde la sesión
$fecha = date("Y-m-d");  // Obtener la fecha actual
$status = 1;  // Estado del vale

// Capturar los valores del primer producto
$coordinacion = isset($_POST['coordinacion_1']) ? $_POST['coordinacion_1'] : null;
$recibio = isset($_POST['recibio_1']) ? $_POST['recibio_1'] : null;

// Manejar la evidencia del primer producto (si existe)
$evidencia = null;
if (isset($_FILES['evidencia_1']) && $_FILES['evidencia_1']['error'] === UPLOAD_ERR_OK) {
    $ruta_destino = '../uploads/' . basename($_FILES['evidencia_1']['name']);
    move_uploaded_file($_FILES['evidencia_1']['tmp_name'], $ruta_destino);
    $evidencia = $ruta_destino;
}

// Insertar el vale en la base de datos
$sql_vale = "INSERT INTO vales (id_usuario, coordinacion, recibio, fecha, evidencia, status) 
             VALUES ('$id_usuario','$coordinacion','$recibio', '$fecha', '$evidencia', '$status')";

if ($conexion->query($sql_vale) === TRUE) {
    // Obtener el ID del vale insertado
    $id_vale = $conexion->insert_id;

    // Obtener el número de productos
    $numProductos = $_POST['numProductos'];

    // Procesar cada producto
    for ($i = 1; $i <= $numProductos; $i++) {
        $id_producto = $_POST["idProducto_$i"];
        $cantidad = $_POST["cantidad_$i"];

        $sql_pctosVl = "INSERT INTO pctos_vale (id_vale, id_producto, cantidad, status) 
                        VALUES ('$id_vale', '$id_producto', '$cantidad', '$status')";
        
        if ($conexion->query($sql_pctosVl) === TRUE) {
            $sql_actualizar = "UPDATE producto SET existencia = existencia - $cantidad WHERE id_producto = '$id_producto'";
            if (!$conexion->query($sql_actualizar)) {
                die("Error al actualizar la existencia: " . $conexion->error);
            }
        } else {
            die("Error al registrar el detalle: " . $conexion->error);
        }
    }

    echo "Vale registrado correctamente con ID: $id_vale";  // Mensaje de éxito
} else {
    die("Error al registrar el vale: " . $conexion->error);  // Manejo de errores
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>
