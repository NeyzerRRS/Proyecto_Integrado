<?php
    include_once "../conexionesBD.php";
    $conexion = conectarBD();

    // Asegúrate de escapar las variables de entrada para evitar inyecciones
    $movimiento = mysqli_real_escape_string($conexion, $_GET['movimiento']);
    $idProducto = mysqli_real_escape_string($conexion, $_GET['id']);

    $tituloPag = "Agregar Devolución";

    // Consulta para obtener motivos
    $consultaMotivoSQL = "SELECT M.id_motivo, M.motivo FROM motivos AS M WHERE M.status = 1;";
    $resultadoMotivo = mysqli_query($conexion, $consultaMotivoSQL);

    // Comprobar que la consulta de motivos se ejecutó correctamente
    if (!$resultadoMotivo) {
        die('Error en la consulta de motivos: ' . mysqli_error($conexion));
    }

    // Consulta para obtener usuarios
    /*$consultaUsuarioSQL = "SELECT id_usuario, nombre FROM usuarios WHERE status = 1;";
    $resultadoUsuario = mysqli_query($conexion, $consultaUsuarioSQL);

    // Comprobar que la consulta de usuarios se ejecutó correctamente
    if (!$resultadoUsuario) {
        die('Error en la consulta de usuarios: ' . mysqli_error($conexion));
    }*/
     
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
        <a href="../Home.php"><img src="../Imagenes/Logo-removebg-preview.png" alt="Logo"></a>
        <div class="User">
            <!--QUITAR 8080 -->
            <form class="User_icon" action="http://localhost:8080/Proyecto_Integrado/logout.php" method="post">
            <button class="Btn">
                <div class="sign"><svg viewBox="0 0 512 512">
                    <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path><svg>
                </div>
            <div class="text">Cerrar sesión</div>
            </button>
        </form>
            <img class="User_icon" src="../Imagenes/colegio.png" alt="User Icon">
        </div>
        <h1 class="Inventario"><?php echo htmlspecialchars($tituloPag); ?></h1>
    </header>
  <?php include "../Menu.php"; ?> <br>
      <?php
        $id_usuario = $_SESSION['id_usuario'];

        // Consultar el nombre del usuario en la base de datos
        $query = "SELECT nombre FROM usuarios WHERE id_usuario = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $stmt->bind_result($nombre_usuario);
        $stmt->fetch();
        $stmt->close();
    ?>
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
        <input type="hidden" name="nUsuario" id="usuario-<?php echo $id_usuario; ?>" value="<?php echo $id_usuario; ?>" checked>
        <label for="usuario-<?php echo $id_usuario; ?>"><?php echo htmlspecialchars($nombre_usuario); ?></label>
        <br><br>
        <input class="btn-Rv" type="submit" name="Continuar"><br><br>
        
    </form>
    <a href="Devoluciones.php">
        <button class="btn-Rv">Volver</button>
    </a>
</body>
</html>
<?php
mysqli_close($conexion);
?>
