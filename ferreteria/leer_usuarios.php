<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Leer Usuarios</title>
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
        .center-text {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-5">Lista de Usuarios</h1>
        <?php
        // Incluir el archivo de conexión a la base de datos
        include('db.php');

        // Consultar todos los usuarios en la base de datos
        $sql = "SELECT usuario, rol FROM usuarios";
        $result = mysqli_query($conn, $sql);

        // Inicializar arrays para almacenar usuarios por rol
        $clientes = array();
        $administradores = array();

        // Verificar si se encontraron usuarios
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row["rol"] == "cliente") {
                    $clientes[] = $row["usuario"];
                } else if ($row["rol"] == "administrador") {
                    $administradores[] = $row["usuario"];
                }
            }
        } else {
            echo "<div class='alert alert-warning text-center mt-3'>No hay usuarios disponibles.</div>";
        }

        // Mostrar usuarios por rol
        if (!empty($clientes)) {
            echo "<h2 class='mt-5'>Clientes</h2>";
            echo "<ul class='list-group'>";
            foreach ($clientes as $cliente) {
                echo "<li class='list-group-item'>" . htmlspecialchars($cliente) . "</li>";
            }
            echo "</ul>";
        }

        if (!empty($administradores)) {
            echo "<h2 class='mt-5'>Administradores</h2>";
            echo "<ul class='list-group'>";
            foreach ($administradores as $admin) {
                echo "<li class='list-group-item'>" . htmlspecialchars($admin) . "</li>";
            }
            echo "</ul>";
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
