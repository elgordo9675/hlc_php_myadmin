<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Filtrar Productos</title>
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
        <h1 class="text-center mt-5">Filtrar Productos</h1>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="filtrar_productos.php" method="get" class="form-inline">
                    <div class="form-group mb-2">
                        <label for="nombre" class="mr-2">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" class="form-control">
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <label for="precio_min" class="mr-2">Precio Mínimo:</label>
                        <input type="number" step="0.01" id="precio_min" name="precio_min" class="form-control">
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <label for="precio_max" class="mr-2">Precio Máximo:</label>
                        <input type="number" step="0.01" id="precio_max" name="precio_max" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Filtrar</button>
                </form>
            </div>
        </div>

        <?php
        // Incluir el archivo de conexión a la base de datos
        include('db.php');

        // Obtener valores del formulario
        $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : '';  // Valor del nombre a filtrar
        $precio_min = isset($_GET['precio_min']) ? $_GET['precio_min'] : '';  // Valor del precio mínimo a filtrar
        $precio_max = isset($_GET['precio_max']) ? $_GET['precio_max'] : '';  // Valor del precio máximo a filtrar

        // Construir la consulta SQL para filtrar productos
        $sql = "SELECT * FROM productos WHERE 1=1";
        if ($nombre != '') {
            $sql .= " AND nombre LIKE '%" . mysqli_real_escape_string($conn, $nombre) . "%'";
        }
        if ($precio_min != '') {
            $sql .= " AND precio >= " . mysqli_real_escape_string($conn, $precio_min);
        }
        if ($precio_max != '') {
            $sql .= " AND precio <= " . mysqli_real_escape_string($conn, $precio_max);
        }

        // Ejecutar la consulta
        $result = mysqli_query($conn, $sql);

        // Verificar si se encontraron productos
        if (mysqli_num_rows($result) > 0) {
            // Mostrar los productos en una tabla
            echo "<table class='table table-bordered mt-3'>";
            echo "<thead><tr><th>Nombre</th><th>Descripción</th><th>Precio</th><th>Stock</th></tr></thead><tbody>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>" . htmlspecialchars($row["nombre"]) . "</td>
                        <td>" . htmlspecialchars($row["descripcion"]) . "</td>
                        <td>" . htmlspecialchars($row["precio"]) . "</td>
                        <td>" . htmlspecialchars($row["stock"]) . "</td>
                    </tr>";
            }
            echo "</tbody></table>";
        } else {
            // Mostrar mensaje si no se encontraron productos
            echo "<div class='alert alert-warning text-center mt-3'>No se encontraron productos.</div>";
        }

        // Cerrar la conexión con la base de datos
        mysqli_close($conn);
        ?>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
