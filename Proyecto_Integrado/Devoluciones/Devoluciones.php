<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Papelería UNES</title>
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
        <h1 class="Inventario">Devoluciones</h1>
    </header>
    
    <?php include "../Menu.php"; ?>
    
    <br>
    <div class="buscador2">
        <i class="fas fa-search"></i>
        <form action="Devoluciones.php" method="GET">
            <input type="text" class="search_bar" name="tipoProducto" placeholder="Buscar Devolución por Usuario">
        </form>
    </div>
    <a href="registrar_devolucion.php?movimiento=alta&id=NULL"><input type="submit" class="AgregarP" value="Agregar Devolución Nueva"></a>
    <?php
    require_once "../conexionesBD.php";
    $conexion = conectarBD();

    // Recuperar el ID del usuario desde la sesión
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

    // Captura el término de búsqueda de tipoProducto
    $tpProducto = isset($_GET['tipoProducto']) ? $_GET['tipoProducto'] : '';

    // Consulta base para seleccionar productos
    $consulta = "SELECT dv.fecha,dv.id_usuario, u.nombre AS nUsuario, dv.id_motivo,dv.cantidad, p.id_producto, p.nombre, dv.importe, m.motivo ";
    $consulta .= "FROM  producto AS p "; 
    $consulta .= "INNER JOIN tipo_producto AS tp ON p.id_tipo = tp.id_tipo ";
    $consulta .= "INNER JOIN devolucion_cliente AS dv ON dv.id_producto = p.id_producto ";
    $consulta .= "INNER JOIN motivos AS m ON m.id_motivo=dv.id_motivo ";
    $consulta .= "INNER JOIN usuarios AS u ON u.id_usuario = dv.id_usuario ";
    $consulta .= "WHERE dv.status=1";
    // Si el usuario ha ingresado un término de búsqueda
    if (!empty($tpProducto)) {
        $tpProducto = mysqli_real_escape_string($conexion, $tpProducto);
       
        $consulta .= " AND u.nombre LIKE '%$tpProducto%'";
    }
    $consulta .= " ORDER BY dv.fecha DESC";
    //Ejecutamos la consulta
    $resultado = mysqli_query($conexion,$consulta);
    ?>
    <!--Opcional: Manejo adicional según roles-->
    <?php if ($rol == 'Administrativo') {?>

    <?php } elseif ($rol == 'Encargado') {?>
    <?php } else {
        echo "Rol no reconocido.";
        session_destroy();
        header("Location: index.php");
        exit();
    }?>
    <!-- Mostrar resultados o un mensaje si no hay productos -->
    <?php if (mysqli_num_rows($resultado) > 0) { ?>
        <br><br><br>
        <table class="Devoluciones">
            <tr class="Devoluciones">
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Importe</th>
                <th>Fecha y Hora </th>
                <th>Usuario</th>
                <th>Motivo</th>

            </tr>
            <?php while ($pcto = mysqli_fetch_assoc($resultado)) { ?>
            <tr>
                <td><?php echo $pcto["nombre"]; ?></td>
                <td><?php echo $pcto["cantidad"]; ?></td>
                <td> $<?php echo $pcto["importe"]; ?></td>
                <td><?php echo $pcto["fecha"]; ?></td>
                <td><?php echo $pcto["nUsuario"]; ?></td>
                <td><?php echo $pcto["motivo"]; ?></td>
            </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <p class="No_Encontrado">Devolución no encontrada</p>
    <?php } ?>

    <br>
    <a href="../Home.php" class="button">
        <button class="btn-Rv">Volver al Inicio</button>
    </a>

    <script>
        function confirmarEliminar(id) {
            if (confirm("Deseas eliminar el registro " + id + "?")) {
                window.location.href = "eliminar_producto.php?id=" + id;
            }
        }
    </script>
</body>
</html>
<?php
mysqli_close($conexion);
?>