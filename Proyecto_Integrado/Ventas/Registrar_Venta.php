<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/style.css">
    <link rel="stylesheet" href="../jquery/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Papelería UNES</title>
</head>
<body>
    <header>
        <a href="../Home.php"><img src="../Imagenes/Logo-removebg-preview.png"></a>
        <div class="User">
            <!--QUITAR EL :8080 -->
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
        <h1>Venta</h1>
    </header>
    <?php include "../Menu.php"; ?>
    <br>

    <?php
require_once "../conexionesBD.php";
$conexion = conectarBD();

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
mysqli_close($conexion);
?>

    <div class="Fondo_Agregar">
        <div class="buscador2">
            <i class="fas fa-search"></i>
            <input type="text" class="search_bar" id="buscar" name="tipoProducto" placeholder="Añade Productos">
        </div>
    </div>
<form action="guardar_venta.php" method="POST" onsubmit="return validarVenta()">
    <table>
        <thead>
            <tr>
                <th class="PCI_Venta">Producto</th>
                <th class="PCI_Venta">Cantidad</th>
                <th class="PCI_Venta">Precio</th>
                <th class="PCI_Venta">Importe</th>
            </tr>
        </thead>
        <tbody id="contenedor_productos">
            <!-- Dynamic rows will be added here -->
        </tbody>
    </table>

    <div class="linea">_____________________________________________________________________________________________________________</div><br>
    <div class="Importe">
        <label><b>Importe Total:</b></label> <span id="importe_total">0</span>
    </div>
        <button class="Pagar">Pagar</button>
        <input type="hidden" value="0" name="numProductos" name="numProductos" id="numProductos">
    </form><br>
    <!--QUITAR 8080-->
    <a href="http://localhost:8080/Proyecto_Integrado/Vales/Registrar_Vale.php">
        <button class="Pagar">Vale</button><br><br>
    <input type="hidden" value="0" name="numProductos" name="numProductos" id="numProductos">
    </a>
        <input type="hidden" id="idProducto" name="idProducto"disabled>
        <input type="hidden" id="nombre" name="nombre" disabled>
        <input type="hidden" id="precio" name="precio" disabled>

    <script src="../jquery/external/jquery/jquery.js"></script>
    <script src="../jquery/jquery-ui.js"></script>

   <script>

    function validarVenta() {
    let numProductos = document.getElementById("numProductos").value; // Obtener el número de productos
    if (numProductos == 0) {
        alert("Por favor, añade al menos un producto antes de registrar la venta.");
        return false; // Evita el envío del formulario
    }

    // Validar cantidades
    for (let i = 1; i <= numProductos; i++) {
        let cantidad = document.getElementById("cantidad_" + i).value;
        if (cantidad <= 0 || isNaN(cantidad)) {
            alert("La cantidad de cada producto debe ser mayor a 0.");
            return false; // Evita el envío del formulario
        }
    }

    return true; // Permite el envío del formulario si todo es válido
}

    
    $( "#buscar" ).autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "ObtenerProductosV.php",  // PHP backend script to get products
                dataType: "json",
                data: { nombre: request.term },
                success: function (data) {
                    response(data);
                },
                error: function (xhr, status, error) {
                    console.error("Error en la solicitud AJAX:", error);
                }
            });
        },
        select: function (e, ui) {
            // Información del producto seleccionado
            infoProducto = ui.item.label;
            
            // Convierte el string en un arreglo, separado por el carácter pipe
            arrayInfoProducto = infoProducto.split("|");

            // Quita el carácter $ para llenar el campo precio
            arrayInfoProducto[2] = arrayInfoProducto[2].replace("$ ", "");
            
            // Asigna la información del producto a los campos correspondientes
            document.getElementById("idProducto").value = arrayInfoProducto[0];  // Asigna el ID del producto
            document.getElementById("nombre").value = arrayInfoProducto[1];      // Asigna el nombre del producto
            document.getElementById("precio").value = arrayInfoProducto[2];      // Asigna el precio del producto
            
            // Limpia el campo de búsqueda
            document.getElementById("buscar").value = "";

            // Agrega el producto a la tabla
            agregarProducto(arrayInfoProducto);
        }
    });
 $( "#buscar" ).on( "autocompleteclose", function( event, ui ) {
        document.getElementById("buscar").value="";
    } );

function agregarProducto(arrayInfoProducto) {
    let divContenedorProductos = document.getElementById("contenedor_productos");
    let numProductos = document.getElementById("numProductos");
    let indiceProducto = parseInt(numProductos.value) + 1;
    numProductos.value = indiceProducto;

    // Usamos la información del producto (arrayInfoProducto)
    let htmlProducto = '<tr id="detalle_producto_' + indiceProducto + '">';
    htmlProducto += '<td>' + arrayInfoProducto[1] + '</td>'; // Nombre del producto
    htmlProducto += '<td><input class="input_V" type="number" id="cantidad_' + indiceProducto + '" name="cantidad_' + indiceProducto + '" placeholder="Cantidad" onchange="calcularImporte(' + indiceProducto + ')"></td>'; // Cantidad
    htmlProducto += '<td id="precio_' + indiceProducto + '">' + arrayInfoProducto[2] + '</td>'; // Precio (sin editar)
    htmlProducto += '<td> $ <input class="input_V" id="importe_' + indiceProducto + '" value="0" disabled> </td>'; // Importe
    htmlProducto += '<td><input type="hidden" name="idProducto_' + indiceProducto + '" value="' + arrayInfoProducto[0] + '">' + // ID del producto oculto
        '<img class="icono1" onclick="deleteRow(' + indiceProducto + ')" src="../Imagenes/eliminar.png"></td>'; // Icono eliminar
    htmlProducto += '</tr>';

    divContenedorProductos.insertAdjacentHTML('beforeend', htmlProducto);
    calcularImporte(indiceProducto); // Recalcular el importe al agregar el producto
    calcularTotal(); // Recalcular el total
}


    function deleteRow(indice) {
        let row = document.getElementById('detalle_producto_' + indice);
        row.remove();
        calcularTotal(); // Recalcular el total
    }

    function calcularImporte(indice) {
        let cantidad = document.getElementById("cantidad_" + indice).value;
        let precio = document.getElementById("precio_" + indice).textContent; // Obtener el precio directamente de la celda
        precio = parseFloat(precio); // Convertir el precio a número
        let importe = cantidad * precio;

        // Actualiza el importe en la tabla
        document.getElementById("importe_" + indice).value = importe.toFixed(2);

        calcularTotal(); // Recalcular el total después de cambiar el importe
    }

    function calcularTotal() {
        let total = 0;
        let rows = document.querySelectorAll('#contenedor_productos tr');
        rows.forEach(row => {
            let importe = row.querySelector('input[id^="importe_"]').value;
            total += parseFloat(importe) || 0;
        });
        document.getElementById('importe_total').textContent = total.toFixed(2);
    }
</script>
</body>
</html>

