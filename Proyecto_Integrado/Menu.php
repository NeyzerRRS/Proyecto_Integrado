<!-- Load font awesome icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- The navigation menu -->
<div class="navbar">
  <a href="http://localhost/Proyecto_Integrado/Index.php">Inicio</a>
  <div class="subnav">
    <button class="subnavbtn">Inventario <i class="fa fa-caret-down"></i></button>
    <div class="subnav-content">
    <a href="../Inventario/Inventario.php">Ir a Inventario</a>
      <a href="registrar_producto.php?movimiento=alta&id=NULL" class="button">Agregar un producto</a>
    </div>
  </div>
  <div class="subnav">
    <button class="subnavbtn">Ventas <i class="fa fa-caret-down"></i></button>
    <div class="subnav-content">
      <a href="../Ventas/Registrar_Venta.php">Ir a Ventas</a>
    </div>
  </div>
  <div class="subnav">
    <button class="subnavbtn">Devoluciones <i class="fa fa-caret-down"></i></button>
    <div class="subnav-content">
      <a href="../Devoluciones/Devoluciones.php">Ir a Devoluciones</a>
    </div>
  </div>
  <div class="subnav">
    <button class="subnavbtn">Reportes de Ventas <i class="fa fa-caret-down"></i></button>
    <div class="subnav-content">
      <a href="../ReportesV/ReporteV.php">Ir a Reportes de Ventas</a>
    </div>
  </div>
  <a href="#contact">Ayuda</a>
</div>