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
         <div class="buscador">
            <i class="fas fa-search"></i> <!-- Icono de lupa de Font Awesome -->
            <form action="" method="GET">
                <input type="text" class="search_bar" placeholder="Buscar...">
            </form>
        </div>
        <h1>Venta</h1>
    </header>
    <?php include "../Menu.php"; ?>
    <br>
        <div class="Fondo_Agregar"><input type="button" class="btn_Agregar" name="agregar_producto" value="Agregar Producto" onclick="agregarProducto();"><br></div>
       <table>
    <thead>
        <tr>
            <th class="PCI_Venta">Producto</th>
            <th class="PCI_Venta">Cantidad</th>
            <th class="PCI_Venta">Precio</th>
            <th class="PCI_Venta">Importe</th>
        </tr>
        <br>
    </thead>
    <tbody id="contenedor_productos">
        <tr id="detalle_producto1" class="detalle_Producto">
            <td><input class="input_V" id="buscar_1" placeholder="Producto" title="type &quot;a&quot;"></td>
            <td><input class="input_V" type="text" id="cantidad_1" name="cantidad_1" placeholder="Cantidad"></td>
            <td><span id="precio_1">---</span></td>
            <td><span id="importe_1">---</span></td>
            <td><img class="icono1" src="../Imagenes/eliminar.png"></td>
        </tr>
    </tbody>

</table>

        <div class="linea">_____________________________________________________________________________________________________________</div><br>
        <div class="Importe"> <label><b>Importe Total:</b></label> <span id="importe_total">----</span>  </div> 
<form action="">
    <input type="hidden" value="1" name="numProductos" id="numProductos">
</form>

    

        <div id="seleccion_metodo_de_pago"></div>
        
        <input type="submit" class="Pagar" href="#" value="PAGAR">
    </form>

    <script>
        
        function agregarProducto(){
            let divContenedorProductos = document.getElementById("contenedor_productos");
            let numProductos = document.getElementById("numProductos");
            let indiceProducto = parseInt(numProductos.value) + 1;
            numProductos.value = indiceProducto;

            let htmlProducto = '<tr id="detalle_producto_' + indiceProducto + '" class="detalle_Producto">';
            htmlProducto += '<td><input type="text" class="input_V" id="producto_' + indiceProducto + '" name="producto_' + indiceProducto + '" placeholder="Producto"></td>';
            htmlProducto += '<td><input type="text" class="input_V" id="cantidad_' + indiceProducto + '" name="cantidad_' + indiceProducto + '" placeholder="Cantidad"></td>';
            htmlProducto += '<td><span id="precio_' + indiceProducto + '">---</span></td>';
            htmlProducto += '<td><span id="importe_' + indiceProducto + '">---</span></td>';
            htmlProducto += '<td><img class="icono1" src="../Imagenes/eliminar.png"></td>';
            htmlProducto += '</tr>';

            divContenedorProductos.innerHTML += htmlProducto;
        }
    </script>
    
    <script src="../jquery/external/jquery/jquery.js"></script>
    <script src="../jquery/jquery-ui.js"></script>

    <script>
        var availableTags = [
            "ActionScript",
            "AppleScript",
            "Asp",
            "BASIC",
            "C",
            "C++",
            "Clojure",
            "COBOL",
            "ColdFusion",
            "Erlang",
            "Fortran",
            "Groovy",
            "Haskell",
            "Java",
            "JavaScript",
            "Lisp",
            "Perl",
            "PHP",
            "Python",
            "Ruby",
            "Scala",
            "Scheme"
        ];

        $( "#buscar_1" ).autocomplete({
            source: function (request,response){
                $.ajax({
                    url:"ObtenerProductosV.php",
                    dataType:"json",
                    data:{nombre:request.term},
                    succes: function(data){
                        response(data);
                    }
                 }
                    );
            }
        });
    </script>
</body>
</html>
