<?php
	include "../conexionesBD.php";
	$conexion = conectarBD();

	$consulta = "SELECT id_tipo, nombre FROM tipo_producto WHERE status = 1";
		try{
		$resultado = mysqli_query($conexion, $consulta);
	}
		catch(mysqli_sql_exception $e){
		die("Error al eliminar el registro: " . $e->getMessage());
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Consultar Productos</title>
	<link rel="stylesheet" type="text/css" href="css/estilos.css">
</head>
<body>
	<h1>Consultar Productos</h1>
	<form action="resultado_producto.php" method="POST">
	    <label for="tipoProducto">Tipo de producto:</label>
	    <select name="tipoProducto" id="tipoProducto">
	        <option value="">Seleccione uno</option>
	        <?php 
	        while($pcto = mysqli_fetch_assoc($resultado)) { 
	        ?>
	        <option value="<?php echo $pcto['id_tipo']; ?>">
	        	<?php echo $pcto["nombre"]; ?>
	        </option>
	        <?php } ?>        
	    </select><br><br>
	    <input type="submit">
	    <br><br>
	</form>
	<a href="registrar_producto.php?movimiento=alta&id=NULL">Agregar un producto</a>
</body>
</html>