<?php
// Iniciar la sesión
session_start();

// Verificar si el usuario es administrador
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 'administrador') {
    header("Location: login.php");
    exit();
}

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluir el archivo de conexión a la base de datos
    include('db.php');

    // Obtener los valores del formulario y sanitizarlos
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $descripcion = mysqli_real_escape_string($conn, $_POST['descripcion']);
    $precio = mysqli_real_escape_string($conn, $_POST['precio']);
    $stock = mysqli_real_escape_string($conn, $_POST['stock']);

    // Insertar el nuevo producto en la base de datos
    $sql = "INSERT INTO productos (nombre, descripcion, precio, stock) 
            VALUES ('$nombre', '$descripcion', '$precio', '$stock')";

    // Verificar si la inserción fue exitosa
    if (mysqli_query($conn, $sql)) {
        $mensaje = "<div class='alert alert-success text-center mt-3'>Producto añadido exitosamente.</div>";
    } else {
        $mensaje = "<div class='alert alert-danger text-center mt-3'>Error al añadir producto: " . mysqli_error($conn) . "</div>";
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Producto</title>
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
        <h1 class="text-center mt-5">Añadir Nuevo Producto</h1>
        <?php
        // Mostrar mensaje de éxito o error
        if (isset($mensaje)) {
            echo $mensaje;
        }
        ?>
        <form action="añadir_producto.php" method="post" class="mt-4">
            <div class="form-group">
                <!-- Campo para ingresar el nombre del producto -->
                <label for="nombre">Nombre del Producto:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required>
            </div>
            <div class="form-group">
                <!-- Campo para ingresar la descripción del producto -->
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" class="form-control" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <!-- Campo para ingresar el precio del producto -->
                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" step="0.01" class="form-control" required>
            </div>
            <div class="form-group">
                <!-- Campo para ingresar el stock del producto -->
                <label for="stock">Stock:</label>
                <input type="number" id="stock" name="stock" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Añadir Producto</button>
            <a href="admin_menu.php" class="btn btn-secondary btn-block">Volver al Menú</a>
        </form>
    </div>
    <!-- Enlace a Bootstrap JS y dependencias -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
