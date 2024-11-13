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
            <img class="User_icon" src="../Imagenes/IL.png" alt="User Icon">
        </div>
        <h1 class="Inventario">Inventario</h1>
    </header>
    
    <?php include "../Menu.php"; ?>
    
    <br>
    <div class="buscador2">
        <i class="fas fa-search"></i>
        <form action="Inventario.php" method="GET">
            <input type="text" class="search_bar" name="tipoProducto" placeholder="Buscar Producto">
        </form>
    </div>
    
    <?php
    include "../conexionesBD.php";
    $conexion = conectarBD();

    // Captura el término de búsqueda de tipoProducto
    $tpProducto = isset($_GET['tipoProducto']) ? $_GET['tipoProducto'] : '';

    // Consulta base para seleccionar productos
    $consulta = "SELECT p.id_producto, p.nombre, p.existencia, p.precio, tp.nombre AS tpPcto 
                 FROM producto AS p 
                 INNER JOIN tipo_producto AS tp ON p.id_tipo = tp.id_tipo 
                 WHERE tp.status = 1 AND p.status = 1 ";

    // Si el usuario ha ingresado un término de búsqueda
    if (!empty($tpProducto)) {
        $tpProducto = mysqli_real_escape_string($conexion, $tpProducto);
        $consulta .= " AND p.nombre LIKE '%$tpProducto%'";
    }

    // Ejecutamos la consulta
    $resultado = mysqli_query($conexion, $consulta);
    ?>

    <!-- Mostrar resultados o un mensaje si no hay productos -->
    <?php if (mysqli_num_rows($resultado) > 0) { ?>
        <br><br><br>
        <table>
            <tr>
                <th>Nombre</th>
                <th>Existencia</th>
                <th>Precio</th>
                <th>Tipo de Producto</th>

            </tr>
            <?php while ($pcto = mysqli_fetch_assoc($resultado)) { ?>
            <tr>
                <td><?php echo $pcto["nombre"]; ?></td>
                <td><?php echo $pcto["existencia"]; ?></td>
                <td> $<?php echo $pcto["precio"]; ?></td>
                <td><?php echo $pcto["tpPcto"]; ?></td>
                <td class="icono" >
                    <a href="registrar_producto.php?movimiento=cambio&id=<?php echo $pcto["id_producto"]; ?>">
                        <img class="icono1" src="../Imagenes/lapizin.png" alt="Editar">
                    </a>
                </td>
                <td class="icono" >
                    <a href="#" onclick="confirmarEliminar(<?php echo $pcto["id_producto"]; ?>);">
                        <img class="icono1" src="../Imagenes/borrar.png" alt="Eliminar" width='50px' height='50px'>
                    </a>
                </td>
            </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <p class="No_Encontrado">Producto no encontrado</p>
    <?php } ?>

    <br>
    <button class="volver"><a href="../Index.php" class="button">Volver al Inicio</a></button>

    <script>
        function confirmarEliminar(id) {
            if (confirm("Deseas eliminar el registro " + id + "?")) {
                window.location.href = "eliminar_producto.php?id=" + id;
            }
        }
    </script>
</body>
</html>