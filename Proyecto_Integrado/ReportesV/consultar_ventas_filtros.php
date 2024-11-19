<?php
	include "conexionesBD.php";
	$conexion = conectarBD();
    // Checar conexión
	if(!$conexion) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

    $consultaProductos = "SELECT id_producto, nombre FROM producto WHERE status = 1";
    $resultadoProductos = mysqli_query($conexion, $consultaProductos);

    $consultaUsuarios = "SELECT id_usuario, nombre FROM usuarios WHERE status = 1";
    $resultadoUsuarios = mysqli_query($conexion, $consultaUsuarios);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Consulta de Ventas</title>
</head>
<body>
	<h1>Consultar Ventas</h1>
	<form action="mostrar_ventas_filtros.php" method="POST">
	    <label>Producto:</label>
	    <select name="producto" id="producto">
	        <option value="">Seleccione uno</option>
	        <?php 
	        while($pcto = mysqli_fetch_assoc($resultadoProductos)) { 
	        ?>
	            <option value="<?php echo $pcto['id_producto']; ?>">
	                <?php echo $pcto["nombre"]; ?>
	            </option>
	        <?php } ?>
	    </select>
	    <br><br>

	    <label>Usuario:</label>
	    <select name="usuario" id="usuario">
	        <option value="">Seleccione uno</option>
	        <?php while($user = mysqli_fetch_assoc($resultadoUsuarios)) { ?>
	            <option value="<?php echo $user['id_usuario']; ?>">
	                <?php echo $user["nombre"]; ?>
	            </option>
	        <?php } ?>
	    </select>
	    <br><br>

	    <button type="submit">Filtrar</button>
	</form>

	<?php
	    // Cerrar la conexión
	    mysqli_close($conexion);
	?>
</body>
</html>
