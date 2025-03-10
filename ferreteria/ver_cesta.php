<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 'cliente') {
    header("Location: login.php");
    exit();
}

// Obtener la cesta del cliente desde la sesión
$cesta = isset($_SESSION['cesta']) ? $_SESSION['cesta'] : [];

// Actualizar la cantidad de productos en la cesta
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['actualizar'])) {
    $producto_id = $_POST['producto_id'];  // ID del producto a actualizar
    $nueva_cantidad = $_POST['cantidad'];  // Nueva cantidad del producto
    if ($nueva_cantidad > 0) {
        $cesta[$producto_id]['cantidad'] = $nueva_cantidad;
    } else {
        unset($cesta[$producto_id]);  // Eliminar producto si la cantidad es 0
    }
    $_SESSION['cesta'] = $cesta;  // Actualizar la cesta en la sesión
}

// Eliminar un producto de la cesta
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['eliminar'])) {
    $producto_id = $_POST['producto_id'];  // ID del producto a eliminar
    unset($cesta[$producto_id]);  // Eliminar el producto de la cesta
    $_SESSION['cesta'] = $cesta;  // Actualizar la cesta en la sesión
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver Cesta</title>
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
        <h1 class="text-center mt-5">Tu Cesta</h1>
        <?php
        if (empty($cesta)) {
            echo "<div class='alert alert-warning text-center mt-3'>Tu cesta está vacía.</div>";
        } else {
            echo "<table class='table table-bordered mt-3'>";
            echo "<thead><tr><th>Producto</th><th>Cantidad</th><th>Precio Unitario</th><th>Total</th><th>Acciones</th></tr></thead><tbody>";
            $total = 0;
            foreach ($cesta as $producto_id => $producto) {
                $subtotal = $producto['cantidad'] * $producto['precio'];
                $total += $subtotal;
                echo "<tr>
                    <td>{$producto['nombre']}</td>
                    <td>
                        <form action='ver_cesta.php' method='post' style='display:inline;'>
                            <input type='hidden' name='producto_id' value='{$producto_id}'>
                            <input type='number' name='cantidad' value='{$producto['cantidad']}' min='1' class='form-control d-inline' style='width: 70px;'>
                            <button type='submit' name='actualizar' class='btn btn-primary btn-sm'>Actualizar</button>
                        </form>
                    </td>
                    <td>{$producto['precio']}</td>
                    <td>{$subtotal}</td>
                    <td>
                        <form action='ver_cesta.php' method='post' style='display:inline;'>
                            <input type='hidden' name='producto_id' value='{$producto_id}'>
                            <button type='submit' name='eliminar' class='btn btn-danger btn-sm'>Eliminar</button>
                        </form>
                    </td>
                </tr>";
            }
            echo "<tr><td colspan='3' class='text-right'><strong>Total</strong></td><td colspan='2'><strong>{$total}</strong></td></tr>";
            echo "</tbody></table>";
        }
        ?>
        <div class="text-center mt-3">
            <a href="listado_productos.php" class="btn btn-primary">Seguir Comprando</a>
            <a href="confirmar_cesta.php" class="btn btn-success">Confirmar Compra</a>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
