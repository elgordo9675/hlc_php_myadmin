<?php
// Iniciar la sesión
session_start();

// Verificar si el usuario es administrador
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 'administrador') {
    header("Location: login.php");
    exit();
}

// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "ferreteria",3307); // Cambia "nombre_base_datos" por el nombre de tu base de datos

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_POST["id_usuario"];

    // Consulta para eliminar el usuario
    $sql = "DELETE FROM usuarios WHERE id = $id_usuario";
    $resultado = mysqli_query($conexion, $sql);

    if ($resultado) {
        echo "Usuario eliminado correctamente.";
    } else {
        echo "Error al eliminar el usuario: " . mysqli_error($conexion);
    }
}

mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Usuario</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 50px;
            background: url('https://cdn.pixabay.com/photo/2019/03/29/04/35/tools-4088531_960_720.jpg') no-repeat center center fixed;
            background-size: cover;
            background-blend-mode: overlay;
            background-color: rgba(255, 255, 255, 0.5);
        }
    </style>
</head>
<body>
    <h1>Eliminar Usuario</h1>
    <form method="POST" action="">
        <label for="id_usuario">ID del Usuario:</label>
        <input type="number" id="id_usuario" name="id_usuario" required>
        <button type="submit">Eliminar</button>
        <a href="admin_menu.php" class="btn btn-primary btn-block">Volver</a>
    </form>
     <!-- Enlace a Bootstrap JS y dependencias -->
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
