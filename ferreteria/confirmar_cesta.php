<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 'cliente') {
    header("Location: login.php");
    exit();
}

// Obtener la cesta del cliente desde la sesión
$cesta = isset($_SESSION['cesta']) ? $_SESSION['cesta'] : [];

// Verificar si la cesta está vacía
if (empty($cesta)) {
    echo "<div class='alert alert-warning text-center mt-3'>Tu cesta está vacía.</div>";
} else {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include('db.php');
        $usuario = $_SESSION['usuario'];  // Usuario que realiza la compra
        $sql = "SELECT id FROM usuarios WHERE usuario='$usuario'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $usuario_id = $row['id'];  // ID del usuario

        $fecha = date('Y-m-d H:i:s');  // Fecha y hora de la compra
        $total = 0;  // Inicializar el total

        // Calcular el total de la compra
        foreach ($cesta as $producto) {
            $total += $producto['cantidad'] * $producto['precio'];
        }

        $sql = "INSERT INTO ventas (usuario_id, fecha, total) VALUES ($usuario_id, '$fecha', $total)";
        if ($conn->query($sql) === TRUE) {
            $venta_id = $conn->insert_id;  // ID de la venta recién insertada
            foreach ($cesta as $producto) {
                $producto_id = $producto['id'];  // ID del producto
                $cantidad = $producto['cantidad'];  // Cantidad del producto
                $precio_unitario = $producto['precio'];  // Precio unitario del producto

                // Insertar los detalles de la venta
                $sql = "INSERT INTO detalle_ventas (venta_id, producto_id, cantidad, precio_unitario) VALUES ($venta_id, $producto_id, $cantidad, $precio_unitario)";
                $conn->query($sql);

                // Actualizar el stock del producto
                $sql = "UPDATE productos SET stock = stock - $cantidad WHERE id = $producto_id";
                $conn->query($sql);
            }

            // Vaciar la cesta del cliente
            unset($_SESSION['cesta']);
            echo "<div class='alert alert-success text-center mt-3'>Compra confirmada exitosamente.</div>";
        } else {
            // Mostrar mensaje de error si la inserción de la venta falla
            echo "<div class='alert alert-danger text-center mt-3'>Error al confirmar la compra: " . $conn->error . "</div>";
        }

        // Cerrar la conexión con la base de datos
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmar Cesta</title>
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
        <h1 class="text-center mt-5">Confirmar Cesta</h1>
        <?php
        // Verificar si la cesta está vacía
        if (empty($cesta)) {
            echo "<div class='alert alert-warning text-center mt-3'>Tu cesta está vacía.</div>";
        } else {
            // Mostrar los productos en la cesta
            echo "<table class='table table-bordered mt-3'>";
            echo "<thead><tr><th>Producto</th><th>Cantidad</th><th>Precio Unitario</th><th>Total</th></tr></thead><tbody>";
            $total = 0;
            foreach ($cesta as $producto) {
                $subtotal = $producto['cantidad'] * $producto['precio'];
                $total += $subtotal;
                echo "<tr><td>{$producto['nombre']}</td><td>{$producto['cantidad']}</td><td>{$producto['precio']}</td><td>{$subtotal}</td></tr>";
            }
            echo "<tr><td colspan='3' class='text-right'><strong>Total</strong></td><td><strong>{$total}</strong></td></tr>";
            echo "</tbody></table>";
        }
        ?>
        <!-- Formulario para confirmar la compra -->
        <?php if (!empty($cesta)) { ?>
        <form action="confirmar_cesta.php" method="post" class="mt-3">
            <button type="submit" class="btn btn-primary btn-block">Confirmar Compra</button>
            <a href="listado_productos.php" class="btn btn-primary btn-block">Volver a la Lista de Productos</a>
        </form>
        <?php } ?>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

