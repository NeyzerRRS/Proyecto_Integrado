<?php
include_once "conexionesBD.php";
$conexion = conectarBD();

session_start();
// Recuperar el ID del usuario desde la sesión
$id_usuario = $_SESSION['id_usuario'];

// Obtener el rol del usuario desde la base de datos
$query = "SELECT tipo_usuario AS rol FROM usuarios WHERE id_usuario = $id_usuario";
$result = $conexion->query($query);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $rol = $row['rol'];
} else {
    echo "Error al obtener el rol del usuario.";
    session_destroy(); // Cerrar sesión en caso de error crítico
    //Aqui solo borra el 8080 para que furule
    header("Location: http://localhost:8080/Proyecto_Integrado/index.php");
    exit();
}
?>

<!-- Load font awesome icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- The navigation menu -->
<!--Opcional: Manejo adicional según roles-->
<?php if ($rol == 'Administrativo') {?>
<div class="navbar">
  <a href="../Home.php">Inicio</a>
  <div class="subnav">
    <a href="../Inventario/Inventario.php">Inventario</a>
  </div>
  <div class="subnav">
    <a href="../Ventas/Registrar_Venta.php">Ventas</a>
  </div>
  <div class="subnav">
    <a href="../Vales/Registrar_Vale.php">Ventas</a>
  </div>
  <div class="subnav">
    <a href="../Devoluciones/Devoluciones.php">Devoluciones</a>
  </div>
  <div class="subnav">
    <a href="../ReportesV/consultar_reporteV.php">Reporte de Ventas</a>
  </div>
  <a href="ayuda.php">Ayuda</a>
</div>
<?php } elseif ($rol == 'Encargado') {?>
<div class="navbar">
  <a href="../Home.php">Inicio</a>
  <div class="subnav">
    <a href="../Inventario/Inventario.php">Inventario</a>
  </div>
  <div class="subnav">
    <a href="../Ventas/Registrar_Venta.php">Ventas</a>
  </div>
  <div class="subnav">
    <a href="../Vales/Registrar_Vale.php">Vales</a>
  </div>
  <div class="subnav">
    <a href="../Devoluciones/Devoluciones.php">Devoluciones</a>
  </div>
  <div class="subnav">
    <a href="../ReportesV/consultar_reporteV.php">Reporte de Ventas</a>
  </div>
  <a href="ayuda.php">Ayuda</a>
</div>
<?php } else {
    echo "Rol no reconocido.";
    session_destroy();
    header("Location: index.php");
    exit();
}?>
