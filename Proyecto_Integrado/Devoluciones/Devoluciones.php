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
        <a href="../Index.php"><img src="../Imagenes/Logo-removebg-preview.png" alt="Logo"></a>
        <div class="User">
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
    <a href="http://localhost/Proyecto_Integrado/Devoluciones/registrar_devolucion.php?movimiento=alta&id=NULL"><input type="submit" class="AgregarP" value="Agregar Devolución Nueva"></a>
    <?php
    include "../conexionesBD.php";
   
    $conexion = conectarBD();

    // Captura el término de búsqueda de tipoProducto
    $tpProducto = isset($_GET['tipoProducto']) ? $_GET['tipoProducto'] : '';

    // Consulta base para seleccionar productos
    $consulta = "SELECT dv.fecha,dv.id_usuario, usuarios.nombre AS nUsuario ,dv.id_motivo,dv.cantidad ,p.id_producto, p.nombre, dv.importe, Motivo.motivo FROM producto AS p INNER JOIN tipo_producto AS tp ON p.id_tipo = tp.id_tipo INNER JOIN devolucion_cliente AS dv ON dv.id_producto = p.id_producto INNER JOIN Motivo ON Motivo.id_motivo=dv.id_motivo  INNER JOIN usuarios ON usuarios.id_usuario = dv.id_usuario WHERE dv.status=1";
    // Si el usuario ha ingresado un término de búsqueda
    if (!empty($tpProducto)) {
        $tpProducto = mysqli_real_escape_string($conexion, $tpProducto);
       
        $consulta .= " AND usuarios.nombre LIKE '%$tpProducto%'";
    }
    $consulta .= " ORDER BY dv.fecha DESC";
    //Ejecutamos la consulta
    $resultado = mysqli_query($conexion,$consulta);
    ?>

    <!-- Mostrar resultados o un mensaje si no hay productos -->
    <?php if (mysqli_num_rows($resultado) > 0) { ?>
        <br><br><br>
        <table class="Devoluciones">
            <tr lass="Devoluciones">
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
    <button class="btn-Rv"><a href="../Index.php" class="button">Volver al Inicio</a></button>

    <script>
        function confirmarEliminar(id) {
            if (confirm("Deseas eliminar el registro " + id + "?")) {
                window.location.href = "eliminar_producto.php?id=" + id;
            }
        }
    </script>
</body>
</html>