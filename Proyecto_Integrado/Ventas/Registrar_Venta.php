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
        <a href="../Index.php"><img src="../Imagenes/Logo-removebg-preview.png"></a>
        <div class="User">
            <img class="User_icon" src="../Imagenes/colegio.png" alt="User Icon">
        </div>
        <h1>Venta</h1>
    </header>
    <?php include "../Menu.php"; ?>
    <br>
    <div class="Fondo_Agregar">
        <div class="buscador2">
            <i class="fas fa-search"></i>
            <input type="text" class="search_bar" id="buscar" name="tipoProducto" placeholder="Buscar Producto">
        </div>
    </div>

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

    <form action="">
        <input type="hidden" value="1" name="numProductos" id="numProductos">
    </form>

    <a href="AgregarV.php"><input type="submit" class="Pagar" value="PAGAR"></a>

    <script src="../jquery/external/jquery/jquery.js"></script>
    <script src="../jquery/jquery-ui.js"></script>

   <script>
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
        htmlProducto += '<td id="precio_'  + indiceProducto + '">' +arrayInfoProducto[2] + '</td>'; // Precio (sin editar)
        htmlProducto += '<td> $ <input class="input_V" id="importe_' + indiceProducto + '" value="0"  disabled> </td>'; // Importe
        htmlProducto += '<td><img class="icono1" onclick="deleteRow(' + indiceProducto + ')" src="../Imagenes/eliminar.png"></td>'; // Icono eliminar
        htmlProducto += '</tr>';

        divContenedorProductos.insertAdjacentHTML('beforeend', htmlProducto);
        calcularImporte(indiceProducto);  // Recalcular el importe al agregar el producto
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

    <input type="hidden" id="idProducto" name="idProducto">
    <input type="hidden" id="nombre" name="nombre" disabled>
    <input type="hidden" id="precio" name="precio" disabled>

</body>
</html>

