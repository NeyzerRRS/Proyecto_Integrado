<?php
	include "../conexionesBD.php";
	$conexion = conectarBD();

	$idProducto = $_GET['id'];

	$sql = "UPDATE producto SET status = 0 WHERE id_producto = '$idProducto'";

	try{
		$resultado = mysqli_query($conexion, $sql);
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
	<title>Eliminar Producto</title>
	<link rel="stylesheet" href="../Css/style.css">
</head>
<body>
	<h1>Elminacion Exitosa</h1>
	<p>Se elimino correctamente el producto</p>
	<br>
	<button type="submit">
		<a href="Inventario.php">Volver</a>
	</button>
</body>
</html>
<?php
mysqli_close($conexion);
?>
