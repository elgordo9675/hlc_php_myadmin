<?php
session_start();

// Verificar si el usuario ha iniciado sesión y si su rol es cliente
$esCliente = isset($_SESSION['usuario']) && $_SESSION['rol'] == 'cliente';

if (!$esCliente && !isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Productos</title>
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
        .center-text {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-5">Lista de Productos</h1>
        <div class="text-center mt-3">
            <a href="login.php" class="btn btn-secondary">Cerrar Sesión</a>
        </div>
        <?php
        include('db.php');

        // Consultar todos los productos en la base de datos
        $sql = "SELECT * FROM productos";
        $result = mysqli_query($conn, $sql);

        // Verificar si se encontraron productos
        if (mysqli_num_rows($result) > 0) {
            echo "<table class='table table-bordered mt-3'>";
            echo "<thead><tr><th>Nombre</th><th>Descripción</th><th>Precio</th>";
            if ($esCliente) {
                echo "<th>Acciones</th>";
            }
            echo "</tr></thead><tbody>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>" . htmlspecialchars($row["nombre"]) . "</td>
                        <td>" . htmlspecialchars($row["descripcion"]) . "</td>
                        <td>" . htmlspecialchars($row["precio"]) . "</td>";
                if ($esCliente) {
                    echo "<td>
                            <!-- Botón para agregar el producto a la cesta -->
                            <a href='añadir_cesta.php?id=" . $row["id"] . "' class='btn btn-primary btn-sm'>Añadir a la Cesta</a>
                          </td>";
                }
                echo "</tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<div class='alert alert-warning text-center mt-3'>No hay productos disponibles.</div>";
        }

        // Cerrar la conexión con la base de datos
        mysqli_close($conn);
        ?>
    </div>
    <!-- Enlace a Bootstrap JS y dependencias -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

