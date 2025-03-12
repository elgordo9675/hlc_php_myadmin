<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Datos</title>
    <!-- Enlace a Bootstrap CSS -->
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
        <h1 class="text-center mt-5">Modificar o Eliminar Producto</h1>
        <?php
        // Iniciar la sesión
        session_start();

        // Verificar si el usuario es administrador
        if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 'administrador') {
            header("Location: login.php");
            exit();
        }

        // Incluir el archivo de conexión a la base de datos
        include('db.php');

        // Verificar si se ha enviado el formulario para modificar un producto
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modificar'])) {
            $id = $_POST['id'];
            $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
            $descripcion = mysqli_real_escape_string($conn, $_POST['descripcion']);
            $precio = mysqli_real_escape_string($conn, $_POST['precio']);
            $stock = mysqli_real_escape_string($conn, $_POST['stock']);

            // Actualizar los valores del producto en la base de datos
            $sql = "UPDATE productos SET nombre='$nombre', descripcion='$descripcion', precio='$precio', stock='$stock' WHERE id=$id";

            // Verificar si la actualización ha sido exitosa
            if (mysqli_query($conn, $sql)) {
                echo "<div class='alert alert-success text-center mt-3'>Producto modificado exitosamente.</div>";
            } else {
                echo "<div class='alert alert-danger text-center mt-3'>Error: " . $sql . "<br>" . mysqli_error($conn) . "</div>";
            }
        }

        // Verificar si se ha enviado el formulario para eliminar un producto
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['eliminar'])) {
            $id = $_POST['id'];

            // Eliminar el producto de la base de datos
            $sql = "DELETE FROM productos WHERE id=$id";

            // Verificar si la eliminación ha sido exitosa
            if (mysqli_query($conn, $sql)) {
                echo "<div class='alert alert-success text-center mt-3'>Producto eliminado exitosamente.</div>";
            } else {
                echo "<div class='alert alert-danger text-center mt-3'>Error: " . $sql . "<br>" . mysqli_error($conn) . "</div>";
            }
        }

        // Verificar si se ha enviado el formulario para seleccionar un producto
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['seleccionar'])) {
            $id = $_POST['id'];
            $sql = "SELECT * FROM productos WHERE id=$id";
            $result = mysqli_query($conn, $sql);
            $producto = mysqli_fetch_assoc($result);
        }
        ?>

        <!-- Formulario para seleccionar un producto -->
        <form action="modificar_datos.php" method="post" class="mt-3">
            <div class="form-group">
                <label for="id">Seleccionar Producto:</label>
                <select id="id" name="id" class="form-control" required>
                    <?php
                    // Consultar todos los productos en la base de datos
                    $sql = "SELECT id, nombre FROM productos";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row["id"] . "'>" . htmlspecialchars($row["nombre"]) . "</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" name="seleccionar" class="btn btn-primary btn-block">Seleccionar</button>
            <a href="admin_menu.php" class="btn btn-primary btn-block">Volver</a>
        </form>

        <!-- Formulario para modificar un producto -->
        <?php if (isset($producto)) { ?>
        <form action="modificar_datos.php" method="post" class="mt-3">
            <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" class="form-control" required><?php echo htmlspecialchars($producto['descripcion']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="precio">Precio:</label>
                <input type="number" step="0.01" id="precio" name="precio" class="form-control" value="<?php echo htmlspecialchars($producto['precio']); ?>" required>
            </div>
            <div class="form-group">
                <label for="stock">Stock:</label>
                <input type="number" id="stock" name="stock" class="form-control" value="<?php echo htmlspecialchars($producto['stock']); ?>" required>
            </div>
            <button type="submit" name="modificar" class="btn btn-primary btn-block">Modificar Producto</button>
            <button type="submit" name="eliminar" class="btn btn-danger btn-block">Eliminar Producto</button>
        </form>
        <?php } ?>
    </div>
    <!-- Enlace a Bootstrap JS y dependencias -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
