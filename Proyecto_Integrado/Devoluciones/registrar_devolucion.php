<?php
    include "../conexionesBD.php";
    $conexion = conectarBD();

    // Asegúrate de escapar las variables de entrada para evitar inyecciones
    $movimiento = mysqli_real_escape_string($conexion, $_GET['movimiento']);
    $idProducto = mysqli_real_escape_string($conexion, $_GET['id']);

    $tituloPag = "Agregar Devolución";

    // Consulta para obtener motivos
    $consultaMotivoSQL = "SELECT M.id_motivo, M.motivo FROM Motivo AS M WHERE M.status = 1;";
    $resultadoMotivo = mysqli_query($conexion, $consultaMotivoSQL);

    // Comprobar que la consulta de motivos se ejecutó correctamente
    if (!$resultadoMotivo) {
        die('Error en la consulta de motivos: ' . mysqli_error($conexion));
    }

    // Consulta para obtener usuarios
    $consultaUsuarioSQL = "SELECT id_usuario, nombre FROM usuarios WHERE status = 1;";
    $resultadoUsuario = mysqli_query($conexion, $consultaUsuarioSQL);

    // Comprobar que la consulta de usuarios se ejecutó correctamente
    if (!$resultadoUsuario) {
        die('Error en la consulta de usuarios: ' . mysqli_error($conexion));
    }
     
    // Consulta para obtener productos
    $consultaProductoSQL = "SELECT p.id_producto, p.nombre FROM producto AS p WHERE p.status = 1;";
    $resultadoProducto = mysqli_query($conexion, $consultaProductoSQL);
    if (!$resultadoProducto) {
        die('Error en la consulta de productos: ' . mysqli_error($conexion));
    }

    // Asigna valores o deja campos vacíos para nuevos registros
    $nomPcto = $infoProducto['nombre'] ?? "";
    $cantidadPcto = $infoProducto['cantidad'] ?? "";
    $motivoPcto = $infoProducto['motivo'] ?? "";
    $importePcto = $infoProducto['importe'] ?? "";
    $fecha = $infoProducto['fecha'] ?? "";
    $user = $infoProducto['nUsuario'] ?? "";

    // Acción para el formulario
    $action = "guardar_devolucion.php"; 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Agregar Devolución - <?php echo htmlspecialchars($tituloPag); ?></title>
</head>
<body>
    <header>
        <a href="../Index.php"><img src="../Imagenes/Logo-removebg-preview.png" alt="Logo"></a>
        <div class="User">
            <img class="User_icon" src="../Imagenes/colegio.png" alt="User Icon">
        </div>
        <h1 class="Inventario"><?php echo htmlspecialchars($tituloPag); ?></h1>
    </header>
  <?php include "../Menu.php"; ?> <br>
    <form class="registrarP" action="<?php echo htmlspecialchars($action); ?>" method="POST">
        <input type="hidden" name="idProducto" value="<?php echo htmlspecialchars($idProducto); ?>">

        <!-- Producto: Mostrar como lista de selección -->
        <label class="formLabel">Producto:</label><br>
        <select name="nombre" id="nombre" required>
            <option value="">Selecciona un producto</option>
            <?php while ($producto = mysqli_fetch_assoc($resultadoProducto)) { ?>
                <option value="<?php echo $producto['id_producto']; ?>" <?php echo ($producto['id_producto'] == $idProducto) ? "selected" : ""; ?>>
                    <?php echo htmlspecialchars($producto['nombre']); ?>
                </option>
            <?php } ?>
        </select><br>

        <label class="formLabel">Cantidad:</label><br>
        <input type="number" name="cantidad" id="cantidad" placeholder=" Añade una cantidad" value="<?php echo htmlspecialchars($cantidadPcto); ?>" required><br>

        <legend class="formLabel">Motivo:</legend>
        <?php while ($fila = mysqli_fetch_assoc($resultadoMotivo)) { 
            $valorChecked = ($fila['id_motivo'] == $motivoPcto) ? "checked" : "";
        ?>
            <input type="radio" name="motivo" id="tipo-<?php echo $fila['id_motivo']; ?>" value="<?php echo $fila['id_motivo'];?>" <?php echo $valorChecked; ?>>
            <label for="tipo-<?php echo $fila['id_motivo']; ?>"><?php echo htmlspecialchars($fila['motivo']); ?></label>
        <?php } ?>
        <br>

        <label class="formLabel">Importe:</label><br>
        <input type="number" name="importe" id="importe" placeholder=" Añade el Importe" value="<?php echo htmlspecialchars($importePcto); ?>" required><br>

        <?php
        // Establecer la zona horaria a México
        date_default_timezone_set('America/Mexico_City');
        ?>
        <label class="formLabel">Fecha:</label>
        <input type="datetime-local" name="fecha" id="fecha" value="<?php echo date('Y-m-d\TH:i'); ?>" readonly><br>

        <legend class="formLabel">Usuario:</legend>
        <?php while ($fila = mysqli_fetch_assoc($resultadoUsuario)) { 
            $valorChecked = ($fila['id_usuario'] == $user) ? "checked" : "";
        ?>
            <input type="radio" name="nUsuario" id="usuario-<?php echo $fila['id_usuario']; ?>" value="<?php echo $fila['id_usuario'];?>" <?php echo $valorChecked; ?>>
            <label for="usuario-<?php echo $fila['id_usuario']; ?>"><?php echo htmlspecialchars($fila['nombre']); ?></label>
        <?php } ?>
        <br><br>
        <input class="btn-Rv" type="submit" name="Continuar"><br><br>
        
    </form>
    <button class="btn-Rv"><a href="Devoluciones.php">Volver</a></button>
</body>
</html>

