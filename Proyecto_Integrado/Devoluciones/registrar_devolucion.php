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

    // Asigna valores o deja campos vacíos para nuevos registros
    $nomPcto = $infoProducto['nombre'] ?? "";
    $cantidadPcto = $infoProducto['cantidad'] ?? "";
    $motivoPcto = $infoProducto['motivo'] ?? "";
    $importePcto = $infoProducto['importe'] ?? "";
    $fecha = $infoProducto['fecha'] ?? "";
    $user = $infoProducto['nUsuario'] ?? "";

    // Acción para el formulario
    $action = "guardar_devolucion.php"; // Asegúrate de definir la acción correctamente
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
        
        <label>Producto:</label>
        <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($nomPcto); ?>" required><br>


        <label>Cantidad:</label>
        <input type="number" name="cantidad" id="cantidad" value="<?php echo htmlspecialchars($cantidadPcto); ?> "required><br>

        <legend>Motivo:</legend>
        <?php while ($fila = mysqli_fetch_assoc($resultadoMotivo)) { 
            $valorChecked = ($fila['id_motivo'] == $motivoPcto) ? "checked" : "";
        ?>
            <input type="radio" name="motivo" id="tipo-<?php echo $fila['id_motivo']; ?>" value="<?php echo $fila['id_motivo'];?>" <?php echo $valorChecked; ?>>
            <label for="tipo-<?php echo $fila['id_motivo']; ?>"><?php echo htmlspecialchars($fila['motivo']); ?></label>
        <?php } ?>
        <br>

        <label>Importe:</label>
        <input type="number" name="importe" id="importe"  value="<?php echo htmlspecialchars($importePcto); ?>" required><br>

        <?php
        // Establecer la zona horaria a México
        date_default_timezone_set('America/Mexico_City');
        ?>
        <label>Fecha:</label>
        <input type="datetime-local" name="fecha" id="fecha" value="<?php echo date('Y-m-d\TH:i'); ?>" readonly><br>

        <legend>Usuario:</legend>
        <?php while ($fila = mysqli_fetch_assoc($resultadoUsuario)) { 
            $valorChecked = ($fila['id_usuario'] == $user) ? "checked" : "";
        ?>
            <input type="radio" name="nUsuario" id="usuario-<?php echo $fila['id_usuario']; ?>" value="<?php echo $fila['id_usuario'];?>" <?php echo $valorChecked; ?>>
            <label for="usuario-<?php echo $fila['id_usuario']; ?>"><?php echo htmlspecialchars($fila['nombre']); ?></label>
        <?php } ?>
        <br>
        <input type="submit" name="Continuar"><br><br>
        <a href="Devoluciones.php">Volver</a>


    </form>
</body>
</html>




