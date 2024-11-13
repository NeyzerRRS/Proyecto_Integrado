<?php  
	include "../conexionesBD.php";
	$conexion = conectarBD();

	$producto = $_GET['nombre'];

	$sql = "SELECT * FROM producto WHERE nombre like '%$producto%'";

	$resultado = mysqli_query($conexion,$sql);

	$datos = array();

	while ($row= mysqli_fetch_assoc($resultado)) {
		$datos[] =$row['nombre'];
	}

	echo json_encode($datos);

	mysqli_close($conexion);
?>
