<?php
    include "../conexionesBD.php";
    $conexion = conectarBD();

    // Asegúrate de escapar las variables de entrada para evitar inyecciones
    $nomPcto = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $cantidadPcto = mysqli_real_escape_string($conexion, $_POST['cantidad']);
    $motivoPcto = mysqli_real_escape_string($conexion, $_POST['motivo']);
    $importePcto = mysqli_real_escape_string($conexion, $_POST['importe']);
    $fecha = mysqli_real_escape_string($conexion, $_POST['fecha']); // La fecha debe estar entre comillas en la consulta SQL
    $user = mysqli_real_escape_string($conexion, $_POST['nUsuario']);

    // Asegúrate de que las variables estén correctamente definidas y en el formato adecuado
    // Asegurarte de que la fecha esté en el formato adecuado para la base de datos (Y-m-d H:i:s)
    $fechaFormateada = date('Y-m-d H:i:s', strtotime($fecha));

    // Inserción de datos en la tabla de devoluciones
    $sql = "INSERT INTO devolucion_cliente (id_producto, cantidad, id_motivo, importe, fecha, id_usuario) 
            VALUES ('$nomPcto', '$cantidadPcto', '$motivoPcto', '$importePcto', '$fechaFormateada', '$user')";

    try {
        $resultado = mysqli_query($conexion, $sql);
        if (!$resultado) {
            throw new Exception("Error al guardar la información: " . mysqli_error($conexion));
        }
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Guardar Devolución</title>
</head>
<body>
    <h1>La Devolución se registró correctamente</h1>
    <br><br>
    <button type="submit">
        <a href="registrar_devolucion.php?movimiento=alta&id=NULL">Volver a Registrar</a>
    </button>
    <button type="submit">
        <a href="Devoluciones.php">Volver</a>
    </button>
</body>
</html>

<?php
    // Cerrar la conexión con la base de datos
    mysqli_close($conexion);
?>
