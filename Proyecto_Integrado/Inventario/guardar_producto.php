<?php
	include_once "../conexionesBD.php";
	$conexion = conectarBD();

	$nombre = $_POST['nombre'];
	$tipo_pcto = $_POST['tipoProducto'];
	$marca = $_POST['marca'];
	$precio = $_POST['precio'];
	$existencia = $_POST['existencia'];

	$sql = "INSERT INTO producto (nombre, id_tipo, precio, existencia, marca) ";
	$sql .="VALUES ('$nombre', $tipo_pcto, $precio, $existencia, '$marca')";
	try{
		$resultado = mysqli_query($conexion, $sql);
	}
		catch(mysqli_sql_exception $e){
		die("Error al guaradr la informacion: " . $e->getMessage());
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Guardar Producto</title>
</head>
<body>
	<h1>El producto se registro correctamente</b></h1>
	<br><br>
	<button type="submit">
		<a href="registrar_producto.php?movimiento=alta&id=NULL">Volver a Registrar</a>
	</button>
	<button type="submit">
		<a href="Inventario.php">Volver</a>
	</button>
</body>
</html>
<?php
mysqli_close($conexion);
?>