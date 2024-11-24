<?<?php
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
        // Ejecutar la inserción
        $resultado = mysqli_query($conexion, $sql);
        if (!$resultado) {
            throw new Exception("Error al guardar la información de la devolución: " . mysqli_error($conexion));
        }

        // Si la inserción fue exitosa, actualizar la existencia del producto
        $sqlUpdate = "UPDATE producto SET existencia = existencia - $cantidadPcto WHERE id_producto = '$nomPcto'";

        $resultadoUpdate = mysqli_query($conexion, $sqlUpdate);
        if (!$resultadoUpdate) {
            throw new Exception("Error al actualizar la existencia del producto: " . mysqli_error($conexion));
        }
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../Css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Guardar Devolución</title>
</head>
<body>
    <header>

        <div class="User">
            <img class="User_icon" src="../Imagenes/colegio.png" alt="User Icon">
        </div>
        <h1 class="Inventario">Devolución Registrada</h1>
    </header>
    <br>
    <br>
    <?php include "../Menu.php"; ?>
    <br><br>
    <button type="submit" class="btn-Rv">
        <a href="registrar_devolucion.php?movimiento=alta&id=NULL">Volver a Registrar</a>
    </button><br><br>
    <button type="submit" class="btn-Rv">
        <a href="Devoluciones.php">Volver a Devoluciones</a>
    </button>
</body>
</html>

<?php
    // Cerrar la conexión con la base de datos
    mysqli_close($conexion);
?>

