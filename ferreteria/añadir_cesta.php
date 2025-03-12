<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 'cliente') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    include('db.php');
    $producto_id = $_GET['id'];  // ID del producto seleccionado

    // Consultar el producto seleccionado en la base de datos
    $sql = "SELECT * FROM productos WHERE id=$producto_id";
    $result = mysqli_query($conn, $sql);
    $producto = mysqli_fetch_assoc($result);

    // Verificar si el producto fue encontrado
    if ($producto) {
        $nombre = $producto['nombre'];
        $precio = $producto['precio'];
        $cantidad = 1;  // Cantidad predeterminada

        // Obtener la cesta del cliente desde la sesión o crear una nueva
        $cesta = isset($_SESSION['cesta']) ? $_SESSION['cesta'] : [];
        if (isset($cesta[$producto_id])) {
            $cesta[$producto_id]['cantidad'] += $cantidad;  // Aumentar cantidad si ya está en la cesta
        } else {
            $cesta[$producto_id] = array(
                'id' => $producto_id,
                'nombre' => $nombre,
                'precio' => $precio,
                'cantidad' => $cantidad,
            );
        }

        $_SESSION['cesta'] = $cesta;  // Actualizar la cesta en la sesión
        echo "<div class='alert alert-success text-center mt-3'>Producto añadido a la cesta.</div>";
    } else {
        echo "<div class='alert alert-danger text-center mt-3'>Producto no encontrado.</div>";
    }

    mysqli_close($conn);  // Cerrar la conexión con la base de datos
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir a la Cesta</title>
    <!-- Enlace a Bootstrap CSS para estilo responsivo -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 50px;
            background: url('https://cdn.pixabay.com/photo/2019/03/29/04/35/tools-4088531_960_720.jpg') no-repeat center center fixed;
            background-size: cover;
            background-blend-mode: overlay;
            background-color: rgba(255, 255, 255, 0.5); /* Ajusta la transparencia aquí */

        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-5">Añadir a la Cesta</h1>
        <div class="text-center mt-3">
            <a href="listado_productos.php" class="btn btn-primary">Volver a la Lista de Productos</a>
            <a href="ver_cesta.php" class="btn btn-success">Ver Cesta</a>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
