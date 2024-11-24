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
        <h1 class="Inventario">Productos Desactivados</h1>
    </header>
    
    <?php include "../Menu.php"; ?>
    
    <br>
    <div class="buscador2">
        <i class="fas fa-search"></i>
        <form action="P_Desactivados.php" method="GET">
            <input type="text" class="search_bar" name="tipoProducto" placeholder="Buscar Producto Desactivado">
        </form>
    </div>
   
    <?php
    include "../conexionesBD.php";
   
    $conexion = conectarBD();
    $tpProducto = isset($_GET['tipoProducto']) ? $_GET['tipoProducto'] : '';

    // Consulta base para seleccionar productos desactivados
    $consulta = "SELECT p.id_producto, p.nombre, p.existencia, p.precio, tp.nombre AS tpPcto 
                 FROM producto AS p 
                 INNER JOIN tipo_producto AS tp ON p.id_tipo = tp.id_tipo 
                 WHERE tp.status = 1 AND p.status = 0";

    // Aplicar filtro de búsqueda si se proporciona
    if (!empty($tpProducto)) {
        $tpProducto = mysqli_real_escape_string($conexion, $tpProducto);
        $consulta .= " AND p.nombre LIKE '%$tpProducto%'";
    }
    $consulta .= " ORDER BY p.nombre ASC";
    
    $resultado = mysqli_query($conexion, $consulta);
    ?>

    <?php if (mysqli_num_rows($resultado) > 0) { ?>
        <br><br><br>
        <table class="Desactivado">
            <tr>
                <th>Nombre</th>

                <th>Tipo de Producto</th>


            </tr>
            <?php while ($pcto = mysqli_fetch_assoc($resultado)) { ?>
            <tr>
                <td><?php echo htmlspecialchars($pcto["nombre"]); ?></td>

                <td><?php echo htmlspecialchars($pcto["tpPcto"]); ?></td>
                <td class="icono">
                    <a href="Reactivar.php?id=<?php echo htmlspecialchars($pcto["id_producto"]); ?>">
                        <img class="icono1" src="../Imagenes/power.gif" alt="Reactivar">
                    </a>
                </td>
            </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <p class="No_Encontrado">Producto no encontrado</p>
    <?php } ?>

    <br>
    <button class="btn-Rv"><a href="Inventario.php" class="button">Volver a Inventario</a></button>

    <?php mysqli_close($conexion); ?>
</body>
</html>
