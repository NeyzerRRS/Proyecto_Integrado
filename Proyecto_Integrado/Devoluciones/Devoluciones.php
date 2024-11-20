<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Papelería UNES</title>
</head>
<body>
    <header>
        <a href="../Index.php"><img src="../Imagenes/Logo-removebg-preview.png" alt="Logo"></a>
        <div class="User">
            <img class="User_icon" src="../Imagenes/colegio.png" alt="User Icon">
        </div>
        <h1 class="Inventario">Devoluciones</h1>
    </header>
    
    <?php include "../Menu.php"; ?>
    
    <br>
    <div class="buscador2">
        <i class="fas fa-search"></i>
        <form action="../Proyexto:IntegradoInventario.php" method="GET">
            <input type="text" class="search_bar" name="tipoProducto" placeholder="Buscar Producto">
        </form>
    </div>
    
    
</body>
</html>

