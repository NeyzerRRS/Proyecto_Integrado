<?php
	include_once "../conexionesBD.php";
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
	<header>
        <a href="../Home.php"><img src="../Imagenes/Logo-removebg-preview.png" alt="Logo"></a>
        <div class="User">
        	  <!--QUITAR EL 8080-->
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
        <h1><?php echo $tituloPag; ?></h1>
    </header>
	<?php include "../Menu.php"; ?> <br>
	<form class="registrarP" action="<?php echo $action ?>" method="post">
		<input type="hidden" name="idProducto" value="<?php echo $idProducto; ?>">
		<label class="formLabel">Nombre:</label><br>
		<input type="text" name="nombre" id="nombre" value="<?php echo $nomPcto; ?>" required><br>

		<label class="formLabel">Marca:</label><br>
		<input type="text" name="marca" id="marca" value="<?php echo $marcaPcto; ?>"required><br>

		<legend class="formLabel">Tipo de producto:</legend>
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
		<label class="formLabel">Precio:</label><br>
		<input type="text" name="precio" id="precio" value="<?php echo $precioPcto; ?>"required><br>

		<label class="formLabel">Existencia:</label><br>
		<input type="text" name="existencia" id="existencia" value="<?php echo $existenciaPcto; ?>"required><br>
<br>
		<input class="btn-Rv" type="submit" name="Continuar"><br><br>
	</form>
		<a href="Inventario.php">
			<button class="btn-Rv" type="submit">Volver</button>
		</a>
	
</body>
</html>
<?php
mysqli_close($conexion);
?>