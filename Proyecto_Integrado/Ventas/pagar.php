<?php
include "../conexionesBD.php";
$conexion = conectarBD();

// Verifica si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capturar los datos enviados desde el formulario
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $cantidad = (int)$_POST['cantidad'];
    $precio = (float)$_POST['precio'];
    $importe = $cantidad * $precio; // Calcular el importe total

    $sql = "INSERT INTO detalle_venta (id_producto, cantidad, precio, importe) 
            VALUES ('$nombre', $cantidad, $precio, $importe)"; 

    try {
        $resultado = mysqli_query($conexion, $sql);

        if ($resultado) {
            // Si la venta fue exitosa, muestra el mensaje
            $mensaje = 'venta_exitosa';
        } else {
            // Si hubo un error, muestra un mensaje de error
            $mensaje = 'error_registro';
        }
    } catch (Exception $e) {
        // Si ocurre un error al guardar, muestra el mensaje de error
        die("Error al guardar la venta: " . $e->getMessage());
    }

    // Cierra la conexión a la base de datos
    mysqli_close($conexion);
} else {
    // Si no se ha enviado el formulario, se deja vacío el mensaje
    $mensaje = '';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="../Css/style.css">
    <title>Guardar Venta</title>
</head>
<body>
     <header>
        <a href="../Index.php"><img src="../Imagenes/Logo-removebg-preview.png"></a>
        <div class="User">
            <img class="User_icon" src="../Imagenes/colegio.png" alt="User Icon">
        </div>
        <h1>Elige Método de Pago </h1>
    </header>
    <?php if ($mensaje === 'venta_exitosa'): ?>
        <h1>La venta se registró correctamente.</h1>
    <?php elseif ($mensaje === 'error_registro'): ?>
        <h1>Hubo un error al registrar la venta. Por favor, intente nuevamente.</h1>
    <?php endif; ?>

    <br><br>
    <button type="button">
        <a href="registrar_venta.php">Volver a Registrar</a>
    </button>
    <button type="button">
        <a href="ventas.php">Ver Ventas</a>
    </button>
</body>
</html>