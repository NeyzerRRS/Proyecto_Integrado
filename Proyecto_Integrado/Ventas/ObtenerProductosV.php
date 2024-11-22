<?php  
	include "../conexionesBD.php";

	$conexion = conectarBD();

	$producto = $_GET['nombre'];

	$sql = "SELECT CONCAT(id_producto,'|',nombre,'|$ ',precio) as nombre FROM producto WHERE status=1 AND nombre like '%$producto%'";

	$resultado = mysqli_query($conexion,$sql);

	$datos = array();

	while ($row= mysqli_fetch_assoc($resultado)) {
		$datos[] =$row['nombre'];
	}

	echo json_encode($datos);

	mysqli_close($conexion);
?>

