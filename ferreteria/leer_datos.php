<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Leer Datos</title>
    <!-- Enlace a Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    <div class="container">
        <h1 class="text-center mt-5">Lista de Productos</h1>
        <?php
        // Incluir el archivo de conexión a la base de datos
        include('db.php');

        // Consultar todos los productos en la base de datos
        $sql = "SELECT * FROM productos";
        $result = $conn->query($sql);

        // Verificar si se encontraron productos
        if ($result->num_rows > 0) {
            echo "<table class='table table-bordered mt-3'>";
            echo "<thead><tr><th>Nombre</th><th>Descripción</th><th>Precio</th><th>Stock</th></tr></thead><tbody>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["nombre"] . "</td><td>" . $row["descripcion"] . "</td><td>" . $row["precio"] . "</td><td>" . $row["stock"] . "</td></tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<div class='alert alert-warning text-center mt-3'>No hay productos disponibles.</div>";
        }

        // Cerrar la conexión con la base de datos
        $conn->close();
        ?>
    </div>
    <!-- Enlace a Bootstrap JS y dependencias -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
