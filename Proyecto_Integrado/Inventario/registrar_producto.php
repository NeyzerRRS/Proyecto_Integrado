<?php
	include "../conexionesBD.php";
	$conexion = conectarBD();

	
	$movimiento = $_GET['movimiento'];
	$idProducto = $_GET['id'];
	if ($movimiento == "cambio") {
		$tituloPag = "Modificar Producto";
		$action = "modificar_producto.php";
	}elseif ($movimiento == "alta"){
		$tituloPag = "Registrar Producto";
		$action = "guardar_producto.php";
	}
	

    $consultaSQL = "SELECT id_tipo, nombre FROM tipo_producto WHERE status = 1";
    $resultado = mysqli_query($conexion, $consultaSQL);

    $consultaSQLpcto = "SELECT id_producto, nombre, existencia, precio, marca, id_tipo FROM producto WHERE id_producto = ". $idProducto;
    $resultadoSQLpcto = mysqli_query($conexion, $consultaSQLpcto);

    $infoProducto = mysqli_fetch_assoc($resultadoSQLpcto);

    if ($infoProducto == NULL){
    	$nomPcto = "";
    	$marcaPcto = "";
    	$tipoPcto = "";
    	$existenciaPcto = "";
    	$precioPcto = "";

    }
    else{
    	$nomPcto = $infoProducto['nombre'];
    	$marcaPcto = $infoProducto['marca'];
    	$tipoPcto = $infoProducto['id_tipo'];
    	$existenciaPcto = $infoProducto['existencia'];
    	$precioPcto = $infoProducto['precio'];
    }
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $tituloPag; ?></title>
	<link rel="stylesheet" href="../Css/style.css">
</head>

<body>
	<h1><?php echo $tituloPag; ?></h1>
	<form class="registrarP" action="<?php echo $action ?>" method="post">
		<input type="hidden" name="idProducto" value="<?php echo $idProducto; ?>">
		<label>Nombre:</label>
		<input type="text" name="nombre" id="nombre" value="<?php echo $nomPcto; ?>"><br>

		<label>Marca:</label>
		<input type="text" name="marca" id="marca" value="<?php echo $marcaPcto; ?>"><br>

		<legend>Tipo de producto:</legend>
		<?php
		while ($fila = mysqli_fetch_assoc($resultado)) {
			$valorChecked = "";
			if ($fila['id_tipo'] == $tipoPcto){
				$valorChecked = "checked";
			}
			?>
			<input type="radio" name="tipoProducto" id="tipo-<?php echo $fila['id_tipo']; ?>" value="<?php echo $fila['id_tipo'];?>" <?php echo $valorChecked; ?>>
			<label for="tipo-<?php echo $fila['id_tipo']; ?>"><?php echo $fila['nombre']; ?></label>
		<?php
		}
		?>
		<br>
		<label>Precio:</label>
		<input type="text" name="precio" id="precio" value="<?php echo $precioPcto; ?>"><br>

		<label>Existencia:</label>
		<input type="text" name="existencia" id="existencia" value="<?php echo $existenciaPcto; ?>"><br>

		<input type="submit" name="Continuar"><br><br>
	</form>
	<button type="submit">
		<a href="Inventario.php">Volver</a>
	</button>
</body>
</html>