<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Introducir Datos</title>
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
        <h1 class="text-center mt-5">Añadir Producto</h1>
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
            
            // Obtener los valores del formulario
            $nombre = $_POST['nombre'];  // Nombre del producto
            $descripcion = $_POST['descripcion'];  // Descripción del producto
            $precio = $_POST['precio'];  // Precio del producto
            $stock = $_POST['stock'];  // Cantidad de stock del producto

            // Insertar los valores en la tabla de productos
            $sql = "INSERT INTO productos (nombre, descripcion, precio, stock) VALUES ('$nombre', '$descripcion', '$precio', '$stock')";
            
            // Verificar si la inserción ha sido exitosa
            if ($conn->query($sql) === TRUE) {
                echo "<div class='alert alert-success text-center mt-3'>Producto añadido exitosamente.</div>";
            } else {
                // Mostrar mensaje de error si la inserción falla
                echo "<div class='alert alert-danger text-center mt-3'>Error: " . $sql . "<br>" . $conn->error . "</div>";
            }

            // Cerrar la conexión con la base de datos
            $conn->close();
        }
        ?>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="introducir_datos.php" method="post">
                    <div class="form-group">
                        <!-- Campo para ingresar el nombre del producto -->
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <!-- Campo para ingresar la descripción del producto -->
                        <label for="descripcion">Descripción:</label>
                        <textarea id="descripcion" name="descripcion" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <!-- Campo para ingresar el precio del producto -->
                        <label for="precio">Precio:</label>
                        <input type="number" step="0.01" id="precio" name="precio" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <!-- Campo para ingresar el stock del producto -->
                        <label for="stock">Stock:</label>
                        <input type="number" id="stock" name="stock" class="form-control" required>
                    </div>
                    <!-- Botón para enviar el formulario -->
                    <button type="submit" class="btn btn-primary btn-block">Añadir Producto</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Enlace a Bootstrap JS y dependencias -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
